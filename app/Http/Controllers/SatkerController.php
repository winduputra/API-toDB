<?php

namespace App\Http\Controllers;

use App\Models\NonTender;
use App\Models\Satker;
use App\Models\Tender;
use App\Models\TenderSchedule;
use App\Models\StrukturAnggaran;
use App\Models\Swakelola;
use App\Models\Penyedia;
use App\Services\RupService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class SatkerController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function sourceReport()
    {
        $now    = Carbon::now();
        $satker     = Satker::orderBy('nama_satker', 'ASC')->get();
        
        $query      = new Tender();

        $names      = [];
        $codes      = [];
        $data       = [];
        $total      = [
            'package_count' => 0,
            'apbd_pagu' => 0,
            'apbd_hps' => 0,
            'blud_pagu' => 0,
            'blud_hps' => 0,
            'apbn_pagu' => 0,
            'apbn_hps' => 0,
            'dak_pagu' => 0,
            'dak_hps' => 0,
        ];

        foreach ($satker as $key => $value) {
            if( !in_array($value->nama_satker, $names) ) {
                array_push($names, $value->nama_satker);
                array_push($codes, $value->kd_satker_str);
                array_push($data, [
                    'name' => $value->nama_satker,
                    'package_count' => 0,
                    'apbd_pagu' => 0,
                    'apbd_hps' => 0,
                    'blud_pagu' => 0,
                    'blud_hps' => 0,
                    'apbn_pagu' => 0,
                    'apbn_hps' => 0,
                    'dak_pagu' => 0,
                    'dak_hps' => 0,
                ]);
            }
            $query  = $query->orWhere('kd_satker', 'like', $value->kd_satker_str);
        }

        $tenders    = $query->get();
        foreach ($tenders as $key => $value) {
            $index  = array_search($value->kd_satker, $codes);
            if( $index !== false ) {
                $source     = trim(strtolower($value->ang));
                if( $source ) {
                    $paguIndex  = $source . '_pagu';
                    $hpsIndex   = $source . '_hps';
                    $data[$index][$paguIndex] += $value->pagu;
                    $data[$index][$hpsIndex] += $value->hps;
                    $total[$paguIndex]  += $value->pagu;
                    $total[$hpsIndex]   += $value->hps;
                    $data[$index]['package_count'] += 1;
                    $total['package_count']  += 1;
                }
            }
        }

        $html2pdf   = new Html2Pdf('L', 'F4', 'en', true, 'UTF-8', [9, 15, 9, 15]);

        $render     = view('satker.fund-source', compact('data', 'total'));
        $html2pdf->writeHTML($render);

        $html2pdf->output();
    }

    public function categorizeReport()
    {
        $now        = Carbon::now();
        $satker     = Satker::orderBy('nama_satker', 'ASC')->get();
        $tender     = Tender::where('tahun_anggaran', 'like', $now->format("Y"))->where('kd_klpd', '=', 'D264')->whereNotNull('kd_satker')->get();
        $nonTender  = NonTender::where('tanggal_buat_paket', 'like', '%' . $now->format("Y") . '%')->get();

        $satkerCode     = [];
        $data       = [];
        $total      = [
            'package_count' => 0,
            'constructions_process' => 0,
            'constructions_done' => 0,
            'consultations_process' => 0,
            'consultations_done' => 0,
            'goods_process' => 0,
            'goods_done' => 0,
            'services_process' => 0,
            'services_done' => 0,
        ];

        foreach ($satker as $key => $value) {
            if( !in_array($value->kd_satker_str, $satkerCode) ) {
                array_push($satkerCode, $value->kd_satker_str);
                array_push($data, [
                    'name' => $value->nama_satker,
                    'package_count' => 0,
                    'constructions_process' => 0,
                    'constructions_done' => 0,
                    'consultations_process' => 0,
                    'consultations_done' => 0,
                    'goods_process' => 0,
                    'goods_done' => 0,
                    'services_process' => 0,
                    'services_done' => 0,
                ]);
            }
        }

        foreach ($nonTender as $key => $value) {

            $index  = array_search($value->kd_satker, $satkerCode);
            if( $index !== false ) {
                $category   = getCategory($value->kategori_pengadaan);
                if( $category ) {
                    $data[$index]['package_count'] += 1;
                    $total['package_count'] += 1;
                    if( $value->nilai_kontrak ) {
                        // selesai
                        $categoryIndex  = $category . '_done';
                    } else {
                        // proses
                        $categoryIndex  = $category . '_process';
                    }
                    $data[$index][$categoryIndex] += 1;
                    $total[$categoryIndex] += 1;
                }
                
            }
            
        }

        foreach ($tender as $key => $value) {

            $index  = array_search($value->kd_satker, $satkerCode);
            if( $index !== false ) {
                $category   = getCategory($value->jenis_pengadaan);
                if( $category ) {
                    if( $value->nilai_kontrak ) {
                        // selesai
                        $categoryIndex  = $category . '_done';
                    } else {
                        // proses
                        $categoryIndex  = $category . '_process';
                    }
                    $data[$index][$categoryIndex] += 1;
                    $total[$categoryIndex] += 1;
                    $data[$index]['package_count'] += 1;
                    $total['package_count'] += 1;
                }
            }
            
        }

        $html2pdf   = new Html2Pdf('L', 'F4', 'en', true, 'UTF-8', [9, 15, 9, 15]);
        $render     = view('satker.categorize', compact('data', 'total'));
        $html2pdf->writeHTML($render);

        $html2pdf->output();
    }

    public function rup(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));
    $kdSatkerFilter = $request->input('satker', 'Semua');
    // ⬇️ Ambil semua Satker, urut nama, tahun sesuai input
    $satkerList = Satker::where('tahun_anggaran', $tahun)
        ->orderBy('nama_satker')
        ->pluck('nama_satker', 'kd_satker');

    // ⬇️ List satker yg akan direkap (skip kode tertentu, misal 350504)
    $skipSatker = ['350504'];
    $allSatker = $satkerList->filter(function ($nama, $kd) use ($skipSatker) {
        return !in_array($kd, $skipSatker);
    });

    // ⬇️ Ambil data Penyedia & Swakelola untuk tahun dan satker terkait
    $penyedia = Penyedia::where('tahun_anggaran', $tahun)
        ->where('kd_klpd', 'D264')
        ->where('nama_klpd', 'Provinsi Lampung')
        ->where('status_aktif_rup', true)
        ->get();
    $swakelola = Swakelola::where('tahun_anggaran', $tahun)
        ->where('kd_klpd', 'D264')
        ->where('nama_klpd', 'Provinsi Lampung')
        ->where('status_aktif_rup', true)
        ->get();

    // ⬇️ Rekap per Satker (harus semua satker tampil, meskipun 0)
    $rekap = collect();
    foreach ($allSatker as $kdSatker => $namaSatker) {
        // Kalau filter Satker, hanya tampil 1
        if ($kdSatkerFilter !== 'Semua' && $kdSatkerFilter != $kdSatker) continue;

        $penyediaSatker = $penyedia->where('kd_satker', $kdSatker);
        $swakelolaSatker = $swakelola->where('kd_satker', $kdSatker);

        $paketPenyedia = $penyediaSatker->count();
        $paguPenyedia = $penyediaSatker->sum('pagu');
        $paketSwakelola = $swakelolaSatker->count();
        $paguSwakelola = $swakelolaSatker->sum('pagu');
        $paketPenyediaDalamSwakelola = 0;
        $paguPenyediaDalamSwakelola = 0;
        $totalDalamPaket = $paketPenyedia + $paketSwakelola + $paketPenyediaDalamSwakelola;
        $totalPagu = $paguPenyedia + $paguSwakelola + $paguPenyediaDalamSwakelola;

        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker,
            'paket_penyedia' => $paketPenyedia,
            'pagu_penyedia' => $paguPenyedia,
            'paket_swakelola' => $paketSwakelola,
            'pagu_swakelola' => $paguSwakelola,
            'paket_dalam' => $paketPenyediaDalamSwakelola,
            'pagu_dalam' => $paguPenyediaDalamSwakelola,
            'paket_total' => $totalDalamPaket,
            'pagu_total' => $totalPagu,
        ];
    }

    // Total summary
    $grandTotal = [
        'paket_penyedia' => $rekap->sum('paket_penyedia'),
        'pagu_penyedia' => $rekap->sum('pagu_penyedia'),
        'paket_swakelola' => $rekap->sum('paket_swakelola'),
        'pagu_swakelola' => $rekap->sum('pagu_swakelola'),
        'paket_dalam' => $rekap->sum('paket_dalam'),
        'pagu_dalam' => $rekap->sum('pagu_dalam'),
        'paket_total' => $rekap->sum('paket_total'),
        'pagu_total' => $rekap->sum('pagu_total'),
    ];

    // Urutkan rekap by nama satker
    $rekap = $rekap->sortBy('nama_satker');

    // Tahun tersedia (customize kalau perlu)
    $tahunTersedia = Satker::select('tahun_anggaran')->distinct()->orderByDesc('tahun_anggaran')->pluck('tahun_anggaran');

    // View sesuai role
    if (auth()->user()->role_id == 2) {
        return view('users.satker.rup', compact('rekap', 'grandTotal', 'tahun', 'kdSatkerFilter', 'allSatker', 'tahunTersedia'));
    }
    return view('satker.rup', compact('rekap', 'grandTotal', 'tahun', 'kdSatkerFilter', 'allSatker', 'tahunTersedia'));
}

    

public function exportpdf(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));
    $kdSatkerFilter = $request->input('satker', 'Semua');
    $mode  = $request->input('mode', 'I');

    $satkerList = Satker::where('tahun_anggaran', $tahun)
        ->orderBy('nama_satker')
        ->pluck('nama_satker', 'kd_satker');
    $skipSatker = ['350504'];
    $allSatker = $satkerList->filter(function ($nama, $kd) use ($skipSatker) {
        return !in_array($kd, $skipSatker);
    });

    $penyedia = Penyedia::where('tahun_anggaran', $tahun)
        ->where('kd_klpd', 'D264')
        ->where('nama_klpd', 'Provinsi Lampung')
        ->where('status_aktif_rup', true)
        ->get();
    $swakelola = Swakelola::where('tahun_anggaran', $tahun)
        ->where('kd_klpd', 'D264')
        ->where('nama_klpd', 'Provinsi Lampung')
        ->where('status_aktif_rup', true)
        ->get();

    $rekap = collect();
    foreach ($allSatker as $kdSatker => $namaSatker) {
        if ($kdSatkerFilter !== 'Semua' && $kdSatkerFilter != $kdSatker) continue;
        $penyediaSatker = $penyedia->where('kd_satker', $kdSatker);
        $swakelolaSatker = $swakelola->where('kd_satker', $kdSatker);

        $paketPenyedia = $penyediaSatker->count();
        $paguPenyedia = $penyediaSatker->sum('pagu');
        $paketSwakelola = $swakelolaSatker->count();
        $paguSwakelola = $swakelolaSatker->sum('pagu');
        $paketPenyediaDalamSwakelola = 0;
        $paguPenyediaDalamSwakelola = 0;
        $totalDalamPaket = $paketPenyedia + $paketSwakelola + $paketPenyediaDalamSwakelola;
        $totalPagu = $paguPenyedia + $paguSwakelola + $paguPenyediaDalamSwakelola;

        $rekap[$kdSatker] = [
            'nama_satker' => $namaSatker,
            'paket_penyedia' => $paketPenyedia,
            'pagu_penyedia' => $paguPenyedia,
            'paket_swakelola' => $paketSwakelola,
            'pagu_swakelola' => $paguSwakelola,
            'paket_dalam' => $paketPenyediaDalamSwakelola,
            'pagu_dalam' => $paguPenyediaDalamSwakelola,
            'paket_total' => $totalDalamPaket,
            'pagu_total' => $totalPagu,
        ];
    }

    $grandTotal = [
        'paket_penyedia' => $rekap->sum('paket_penyedia'),
        'pagu_penyedia' => $rekap->sum('pagu_penyedia'),
        'paket_swakelola' => $rekap->sum('paket_swakelola'),
        'pagu_swakelola' => $rekap->sum('pagu_swakelola'),
        'paket_dalam' => $rekap->sum('paket_dalam'),
        'pagu_dalam' => $rekap->sum('pagu_dalam'),
        'paket_total' => $rekap->sum('paket_total'),
        'pagu_total' => $rekap->sum('pagu_total'),
    ];

    $rekap = $rekap->sortBy('nama_satker');

    $tanggal = $tahun == 2024
        ? 'Per Desember 2024'
        : 'Per ' . \Carbon\Carbon::now()->translatedFormat('d F Y');

    $html = view('satker.ruppdf', [
        'rekap' => $rekap,
        'grandTotal' => $grandTotal,
        'tanggal' => $tanggal,
        'tahun' => $tahun,
        'satker' => $kdSatkerFilter,
    ])->render();

    $html = '<style>
        body { font-family: sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>' . $html;

    $pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'F4', 'en', true, 'UTF-8', [5, 5, 5, 5]);
    $pdf->writeHTML($html);

    return $pdf->output("laporan-rup-{$tahun}.pdf", $mode);
}



    public function all()
    {
        $now        = Carbon::now();
        $satker     = Satker::orderBy('nama_satker', 'ASC')->get();
        $tender     = Tender::where('tahun_anggaran', 'like', $now->format("Y"))->where('kd_klpd', '=', 'D264')->whereNotNull('kd_satker')->get();
        $nonTender  = NonTender::where('tanggal_buat_paket', 'like', '%' . $now->format("Y") . '%')->get();

        $satkerCode     = [];
        $methodCode     = ['constructions', 'consultations', 'goods', 'services'];

        $data       = [];
        $method     = [
            'constructions' => ['name' => 'KONSTRUKSI', 'package_count' => 0, 'pagu' => 0, 'hps' => 0],
            'consultations' => ['name' => 'JASA KONSULTASI', 'package_count' => 0, 'pagu' => 0, 'hps' => 0],
            'goods' => ['name' => 'PENGADAAN BARANG', 'package_count' => 0, 'pagu' => 0, 'hps' => 0],
            'services' => ['name' => 'JASA LAINNYA', 'package_count' => 0, 'pagu' => 0, 'hps' => 0],
        ];

        $total      = [
            'package_count' => 0,
            'pagu' => 0,
            'hps' => 0,
        ];

        $totalMethod    = [
            'package_count' => 0,
            'pagu' => 0,
            'hps' => 0,
        ];

        foreach ($satker as $key => $value) {
            if( !in_array($value->kd_satker_str, $satkerCode) ) {
                array_push($satkerCode, $value->kd_satker_str);
                array_push($data, [
                    'name' => $value->nama_satker,
                    'package_count' => 0,
                    'pagu' => 0,
                    'hps' => 0,
                ]);
            }
        }

        foreach ($nonTender as $key => $value) {

            $index  = array_search($value->kd_satker, $satkerCode);
            if( $index !== false ) {
                $category   = getCategory($value->kategori_pengadaan);
                if( $category ) {
                    $data[$index]['package_count'] += 1;
                    $total['package_count'] += 1;
                    $totalMethod['package_count'] += 1;
                    $method[$category]['package_count'] += 1;

                    $data[$index]['pagu'] += $value->pagu;
                    $data[$index]['hps'] += $value->hps;

                    $method[$category]['pagu'] += $value->pagu;
                    $method[$category]['hps'] += $value->hps;

                    $total['pagu'] += $value->pagu;
                    $total['hps'] += $value->hps;

                    $totalMethod['pagu'] += $value->pagu;
                    $totalMethod['hps'] += $value->hps;
                }
            }
        }

        foreach ($tender as $key => $value) {

            $index  = array_search($value->kd_satker, $satkerCode);
            if( $index !== false ) {
                $category   = getCategory($value->jenis_pengadaan);
                if( $category ) {
                    $data[$index]['package_count'] += 1;
                    $total['package_count'] += 1;
                    $totalMethod['package_count'] += 1;

                    $data[$index]['pagu'] += $value->pagu;
                    $data[$index]['hps'] += $value->hps;

                    $method[$category]['pagu'] += $value->pagu;
                    $method[$category]['hps'] += $value->hps;

                    $total['pagu'] += $value->pagu;
                    $total['hps'] += $value->hps;

                    $totalMethod['pagu'] += $value->pagu;
                    $totalMethod['hps'] += $value->hps;
                }
            }
            
        }

        $html2pdf   = new Html2Pdf('L', 'F4', 'en', true, 'UTF-8', [9, 12, 9, 12]);
        $render     = view('satker.all', compact('data', 'totalMethod', 'total', 'method'));
        $html2pdf->writeHTML($render);

        $html2pdf->output();
    }

    public function review()
    {
        $now    = Carbon::now();
        $satker     = Satker::orderBy('nama_satker', 'ASC')->get();
        $tender     = Tender::where('tahun_anggaran', 'like', $now->format("Y"))->where('kd_klpd', '=', 'D264')->whereNotNull('kd_satker')->get();
        $tenderIDs  = [];
        foreach ($tender as $key => $value) {
            array_push($tenderIDs, $value->id);
        }

        $satkerCode     = [];
        $data   = [];

        foreach ($satker as $key => $value) {
            if( !in_array($value->kd_satker_str, $satkerCode) ) {
                array_push($satkerCode, $value->kd_satker_str);
                array_push($data, [
                    'name' => $value->nama_satker,
                    'packages' => [],
                ]);
            }
        }
        
        foreach ($tender as $key => $value) {
            $index  = array_search($value->kd_satker, $satkerCode);
            if( $index !== false ) {
                array_push($data[$index]['packages'], $value);
            }
        }

        $html2pdf   = new Html2Pdf('L', 'F4', 'en', true, 'UTF-8', [9, 12, 9, 12]);
        $render     = view('satker.report', compact('data'));
        $html2pdf->writeHTML($render);

        $html2pdf->output();
    }
}