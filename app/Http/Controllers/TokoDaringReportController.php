<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokoDaring;
use App\Models\Satker; // Ubah ke model Satker
use Carbon\Carbon;
use Spipu\Html2Pdf\Html2Pdf;

class TokoDaringReportController extends Controller
{
    public function index(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));
    $satker = $request->input('satker', 'Semua');
    $kdSatkerSkip = ['350504']; // Semua kode yang ingin di-skip

    $data = TokoDaring::where('tahun', $tahun)
    ->where('status_verif', 'verified')
    ->get();

    // Data satker dari master satker
    $satkerFromData = Satker::where('tahun_anggaran', $tahun)
        ->pluck('nama_satker', 'kd_satker')
        ->except($kdSatkerSkip); // ⬅️ Filter di sini juga!

    // Data satker dari transaksi
    $satkerFromDataTokoDaring = $data->pluck('nama_satker', 'kd_satker')
        ->except($kdSatkerSkip); // ⬅️ Filter di sini juga!

    // SatkerList untuk dropdown = satker master yang sudah di-skip
    $satkerList = $satkerFromData;

    // AllSatker (dropdown & tabel) = hasil merge satker master dan transaksi, tanpa skip
    $allSatker = $satkerFromData->merge($satkerFromDataTokoDaring)
        ->filter()
        ->unique();

    // REKAP (tabel)
    $rekap = collect();
    foreach ($data->groupBy('kd_satker') as $kdSatker => $transactions) {
        if (in_array($kdSatker, $kdSatkerSkip)) continue;
        $namaSatker = $satkerFromData->get($kdSatker, $transactions->first()->nama_satker);
        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker,
            'total_transaksi' => $transactions->count(),
            'nilai_transaksi' => $transactions->sum('valuasi'),
        ];
    }

    // Satker tanpa data
    $satkerWithoutData = $satkerFromData->diffKeys($satkerFromDataTokoDaring);
    foreach ($satkerWithoutData as $kdSatker => $namaSatker) {
        if (in_array($kdSatker, $kdSatkerSkip)) continue;
        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker,
            'total_transaksi' => 0,
            'nilai_transaksi' => 0,
        ];
    }

    // FILTER jika satker spesifik
    if ($satker !== 'Semua') {
        $selectedNamaSatker = $satkerList[$satker] ?? 'Satuan Kerja Tidak Diketahui';
        $dataSatker = $rekap->get($satker, [
            'nama_satker' => $selectedNamaSatker,
            'total_transaksi' => 0,
            'nilai_transaksi' => 0,
        ]);
        $rekap = collect([
            $satker => [
                'nama_satker' => $selectedNamaSatker,
                'total_transaksi' => $dataSatker['total_transaksi'],
                'nilai_transaksi' => $dataSatker['nilai_transaksi'],
            ]
        ]);
    }

    $rekap = $rekap->sortBy('nama_satker');
    $totalTransaksi = $rekap->sum('total_transaksi');
    $totalNilai = $rekap->sum('nilai_transaksi');
    $tahunTersedia = collect([2024, 2025]);

    // VIEW
    if (auth()->user()->role_id == 2) {
        return view('users.E-purchasing.tokodaring', compact(
            'rekap', 'tahun', 'satker', 'totalTransaksi', 'totalNilai', 'tahunTersedia', 'satkerList'
        ));
    }
    return view('E-purchasing.tokodaring', compact(
        'rekap', 'tahun', 'satker', 'totalTransaksi', 'totalNilai', 'tahunTersedia', 'satkerList'
    ));
}

    

public function exportPdf(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));
    $satker = $request->input('satker', 'Semua'); // ini harus kd_satker!
    $mode  = $request->input('mode', 'I');

    // Ambil data transaksi tahun terkait
    $data = TokoDaring::where('tahun', $tahun)
    ->where('status_verif', 'verified')
    ->get();

    // Ambil data struktur satker (dari tabel Satker, bukan StrukturAnggaran)
    $satkerFromData = Satker::where('tahun_anggaran', $tahun)
        ->pluck('nama_satker', 'kd_satker');

    // Ambil data nama satker dari transaksi TokoDaring
    $satkerFromDataTokoDaring = $data->pluck('nama_satker', 'kd_satker');

    // Gabungkan nama satker yang ada di TokoDaring
    $allSatker = $satkerFromData->merge($satkerFromDataTokoDaring)
        ->filter()
        ->unique()
        ->sort()
        ->values();

    // Rekap semua satker, grupkan berdasarkan kd_satker, ambil nama satker dari Satker
    $rekap = collect();
    foreach ($data->groupBy('kd_satker') as $kdSatker => $transactions) {
        // Ambil nama satker dari Satker jika ada, jika tidak ambil dari transaksi TokoDaring
        $namaSatker = $satkerFromData->get($kdSatker, $transactions->first()->nama_satker);

        // Gabungkan data transaksi untuk kd_satker yang sama
        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker, // Menampilkan nama satker
            'total_transaksi' => $transactions->count(),
            'nilai_transaksi' => $transactions->sum('valuasi'),
        ];
    }

    // Tambahkan satker yang tidak ada di data transaksi TokoDaring (dari Satker)
    $satkerWithoutData = $satkerFromData->diffKeys($satkerFromDataTokoDaring);
    foreach ($satkerWithoutData as $kdSatker => $namaSatker) {
        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker,
            'total_transaksi' => 0,
            'nilai_transaksi' => 0,
        ];
    }

    // ⬇️ FILTER SATKER jika tidak "Semua" (dengan asumsi satker = kd_satker)
    if ($satker !== 'Semua') {
        $selectedNamaSatker = $satkerFromData[$satker] ?? 'Satuan Kerja Tidak Diketahui';
        $dataSatker = $rekap->get($satker, [
            'nama_satker' => $selectedNamaSatker,
            'total_transaksi' => 0,
            'nilai_transaksi' => 0,
        ]);
        $rekap = collect([
            $satker => [
                'nama_satker' => $selectedNamaSatker,
                'total_transaksi' => $dataSatker['total_transaksi'],
                'nilai_transaksi' => $dataSatker['nilai_transaksi'],
            ]
        ]);
    }

    // Urutkan rekap berdasarkan nama satker
    $rekap = $rekap->sortBy('nama_satker');

    // Ambil daftar satker untuk dropdown
    $satkerList = Satker::where('tahun_anggaran', $tahun)->pluck('nama_satker', 'kd_satker');

    // Tanggal untuk header PDF
        $tanggal = $tahun == 2024
            ? '31 Desember 2024'
            : Carbon::now()->locale('id')->translatedFormat('d F Y');

    // Render HTML untuk PDF
    $html = view('E-purchasing.tokodaring-pdf', [
        'rekap' => $rekap,
        'tanggal' => $tanggal,
        'tahun' => $tahun,
        'satker' => $satker,
        'satkerList' => $satkerList, // Daftar satker
    ])->render();

    // Tambahkan style untuk PDF
    $html = '<style>
        body { font-family: sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>' . $html;

    // Generate PDF menggunakan Html2Pdf
    $pdf = new Html2Pdf('P', 'A4', 'fr');
    $pdf->writeHTML($html);

    // Output PDF
    return $pdf->output("laporan-tokodaring-{$tahun}.pdf", $mode);
}




}

