<?php

namespace App\Http\Controllers;

use App\Models\NonTenderPengumuman;
use App\Models\TenderPengumumanData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    // Mendapatkan tahun dari request, default tahun saat ini
    $tahun = $request->input('tahun', Carbon::now()->year);
    $jenisPengadaan = $request->input('jenis_pengadaan', 'Non Tender'); // Mendapatkan jenis pengadaan yang dipilih

    // Data untuk Grafik Pie "Tender vs Non Tender"
    $totalNonTender = NonTenderPengumuman::where('tahun_anggaran', $tahun)
        ->whereIn('status_nontender', ['Selesai', 'Berlangsung'])
        ->count();

    $totalTender = TenderPengumumanData::where('tahun', $tahun)
        ->whereIn('status_tender', ['Selesai', 'Berlangsung'])
        ->count();

    $chart1Data = [
        'Non Tender' => $totalNonTender,
        'Tender' => $totalTender,
    ];

    // Data untuk Grafik Pie "Jenis Pengadaan" berdasarkan pilihan dropdown
    if ($jenisPengadaan == 'Non Tender') {
        $chart2Data = NonTenderPengumuman::where('tahun_anggaran', $tahun)
            ->whereIn('status_nontender', ['Selesai', 'Berlangsung'])
            ->select('jenis_pengadaan', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis_pengadaan')
            ->pluck('jumlah', 'jenis_pengadaan');
    } else {
        $chart2Data = TenderPengumumanData::where('tahun', $tahun)
            ->whereIn('status_tender', ['Selesai', 'Berlangsung'])
            ->select('jenis_pengadaan', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis_pengadaan')
            ->pluck('jumlah', 'jenis_pengadaan');
    }

    // Kirimkan data ke tampilan dashboard
    return view('dashboard.index', compact('chart1Data', 'chart2Data', 'tahun', 'jenisPengadaan'));
}



}
