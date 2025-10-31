<?php

namespace App\Http\Controllers;

use App\Models\NonTenderPengumuman;
use App\Models\Satker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StrukturAnggaran;
use Spipu\Html2Pdf\Html2Pdf;


class NonTenderController extends Controller
{
    public function index(Request $request)
    {
        $year         = $request->input('year', date('Y'));
        $satkerCode   = $request->input('kd_satker');
        $code         = $request->input('code');
        $name         = $request->input('name');
        $categoryParam= $request->input('category');
        $perPage      = $request->input('per_page', 30);
        $status       = $request->input('status_nontender', '');

        $statusList = [
            '' => 'Semua Status',
            'Berlangsung' => 'Berlangsung',
            'Selesai'     => 'Selesai'
        ];

        // Ambil Satker unique
        $satkers = Satker::where('kd_klpd', 'D264')
            ->where('kd_satker', '!=', '350504')
            ->select('kd_satker', 'kd_satker_str', 'nama_satker')
            ->orderBy('nama_satker')
            ->get()
            ->unique('kd_satker_str')
            ->values();

        // Query utama, sama persis dgn search
        $query = NonTenderPengumuman::query()
            ->leftJoin('non_tender_selesai', 'non_tender_pengumuman.kd_nontender', '=', 'non_tender_selesai.kd_nontender')
            ->leftJoin('non_tender_contract', 'non_tender_pengumuman.kd_nontender', '=', 'non_tender_contract.kd_nontender')
            ->leftJoin('satkers', 'non_tender_pengumuman.kd_satker_str', '=', 'satkers.kd_satker_str')
            ->where('non_tender_pengumuman.kd_satker', '!=', '350504')
            ->where('non_tender_pengumuman.tahun_anggaran', $year)
            ->where('non_tender_pengumuman.kd_klpd', 'D264');

        // Filter status
        if ($status && in_array($status, ['Berlangsung', 'Selesai'])) {
            $query->where('non_tender_pengumuman.status_nontender', $status);
        } else {
            $query->whereIn('non_tender_pengumuman.status_nontender', ['Selesai', 'Berlangsung']);
        }
        if ($categoryParam) $query->where('non_tender_pengumuman.jenis_pengadaan', 'like', "%$categoryParam%");
        if ($code) $query->where('non_tender_pengumuman.kd_nontender', 'like', "%$code%");
        if ($name) $query->whereRaw('LOWER(non_tender_pengumuman.nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
        if ($satkerCode) $query->where('non_tender_pengumuman.kd_satker_str', $satkerCode);

        $data = $query->select(
                'non_tender_pengumuman.kd_nontender',
                'non_tender_pengumuman.kd_klpd',
                'non_tender_pengumuman.kd_satker',
                'non_tender_pengumuman.kd_satker_str',
                'non_tender_pengumuman.tahun_anggaran',
                'non_tender_pengumuman.nama_paket',
                'non_tender_pengumuman.status_nontender',
                'non_tender_pengumuman.hps',
                'non_tender_pengumuman.jenis_pengadaan',
                'non_tender_pengumuman.pagu',
                'satkers.nama_satker',
                DB::raw('COALESCE(non_tender_contract.nilai_pdn_kontrak, non_tender_selesai.nilai_pdn_kontrak, 0) as nilai_pdn_kontrak'),
                DB::raw('COALESCE(non_tender_contract.nilai_umk_kontrak, non_tender_selesai.nilai_umk_kontrak, 0) as nilai_umk_kontrak')
            )
            ->groupBy([
                'non_tender_pengumuman.kd_nontender',
                'non_tender_pengumuman.kd_klpd',
                'non_tender_pengumuman.kd_satker',
                'non_tender_pengumuman.kd_satker_str',
                'non_tender_pengumuman.tahun_anggaran',
                'non_tender_pengumuman.nama_paket',
                'non_tender_pengumuman.status_nontender',
                'non_tender_pengumuman.hps',
                'non_tender_pengumuman.jenis_pengadaan',
                'non_tender_pengumuman.pagu',
                'satkers.nama_satker',
                'non_tender_contract.nilai_pdn_kontrak',
                'non_tender_selesai.nilai_pdn_kontrak',
                'non_tender_contract.nilai_umk_kontrak',
                'non_tender_selesai.nilai_umk_kontrak',
            ])
            ->orderByRaw("
                CASE 
                    WHEN non_tender_pengumuman.status_nontender = 'Berlangsung' THEN 0
                    WHEN non_tender_pengumuman.status_nontender = 'Selesai' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('non_tender_pengumuman.nama_paket', 'asc')
            ->paginate($perPage)
            ->appends([
                'code' => $code,
                'name' => $name,
                'kd_satker' => $satkerCode,
                'year' => $year,
                'category' => $categoryParam,
                'status_nontender' => $status,
                'per_page' => $perPage,
                'page' => $request->input('page', 1),
            ]);

        $years = NonTenderPengumuman::select('tahun_anggaran')->distinct()->orderBy('tahun_anggaran', 'desc')->pluck('tahun_anggaran')->toArray();

        $statusForCategory = ($status && in_array($status, ['Berlangsung', 'Selesai'])) ? [$status] : ['Selesai', 'Berlangsung'];
        if ($satkerCode) {
            $categoriesRaw = NonTenderPengumuman::where('tahun_anggaran', $year)
                ->where('kd_klpd', 'D264')
                ->where('kd_satker_str', $satkerCode)
                ->whereIn('status_nontender', $statusForCategory)
                ->select('jenis_pengadaan')
                ->distinct()
                ->pluck('jenis_pengadaan')
                ->toArray();
        } else {
            $categoriesRaw = NonTenderPengumuman::where('tahun_anggaran', $year)
                ->where('kd_klpd', 'D264')
                ->whereIn('status_nontender', $statusForCategory)
                ->select('jenis_pengadaan')
                ->distinct()
                ->pluck('jenis_pengadaan')
                ->toArray();
        }

        $categories = [];
        $categoriesCount = [];
        foreach ($categoriesRaw as $category) {
            $catQuery = NonTenderPengumuman::where('tahun_anggaran', $year)
                ->where('kd_klpd', 'D264')
                ->where('jenis_pengadaan', $category)
                ->whereIn('status_nontender', $statusForCategory);
            if ($code) $catQuery->where('kd_nontender', 'like', "%$code%");
            if ($name) $catQuery->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
            if ($satkerCode) $catQuery->where('kd_satker_str', $satkerCode);

            $count = $catQuery->count();
            if ($count > 0 || !$satkerCode) {
                $categories[] = $category;
                $categoriesCount[] = $count;
            }
        }

        $total = $data->total();

        if ($satkerCode) {
            $totalFullQuery = NonTenderPengumuman::where('tahun_anggaran', $year)
                ->where('kd_klpd', 'D264')
                ->whereIn('status_nontender', $statusForCategory);
            if ($satkerCode) $totalFullQuery->where('kd_satker_str', $satkerCode);
            if ($code) $totalFullQuery->where('kd_nontender', 'like', "%$code%");
            if ($name) $totalFullQuery->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
            $totalFull = $totalFullQuery->count();
        } else {
            $totalFull = NonTenderPengumuman::where('tahun_anggaran', $year)
                ->where('kd_klpd', 'D264')
                ->whereIn('status_nontender', $statusForCategory)
                ->count();
        }

        $url = url()->full();
        if (!str_contains($url, "?")) $url .= "?";

        $view = (auth()->user()->role_id == 2)
            ? 'users.non-tender.index-lte'
            : 'non-tender.index-lte';

        return view($view, compact(
            'satkers', 'years', 'data', 'total', 'totalFull',
            'code', 'name', 'year', 'satkerCode',
            'categories', 'categoriesCount', 'url', 'categoryParam',
            'status', 'statusList'
        ));
    }

    public function search(Request $request)
    {
        $code = $request->input('code');
        $name = $request->input('name');
        $year = $request->input('year', date('Y'));
        $satkerCode = $request->input('kd_satker');
        $categoryParam = $request->input('category');
        $status = $request->input('status_nontender', '');
        $perPage = 30;

        $query = NonTenderPengumuman::query()
            ->leftJoin('non_tender_selesai', 'non_tender_pengumuman.kd_nontender', '=', 'non_tender_selesai.kd_nontender')
            ->leftJoin('non_tender_contract', 'non_tender_pengumuman.kd_nontender', '=', 'non_tender_contract.kd_nontender')
            ->leftJoin('satkers', 'non_tender_pengumuman.kd_satker_str', '=', 'satkers.kd_satker_str')
            ->where('non_tender_pengumuman.kd_satker', '!=', '350504')
            ->where('non_tender_pengumuman.tahun_anggaran', $year)
            ->where('non_tender_pengumuman.kd_klpd', 'D264');

        if ($status && in_array($status, ['Berlangsung', 'Selesai'])) {
            $query->where('non_tender_pengumuman.status_nontender', $status);
        } else {
            $query->whereIn('non_tender_pengumuman.status_nontender', ['Selesai', 'Berlangsung']);
        }
        if ($categoryParam) $query->where('non_tender_pengumuman.jenis_pengadaan', 'like', "%$categoryParam%");
        if ($code) $query->where('non_tender_pengumuman.kd_nontender', 'like', "%$code%");
        if ($name) $query->whereRaw('LOWER(non_tender_pengumuman.nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
        if ($satkerCode) $query->where('non_tender_pengumuman.kd_satker_str', $satkerCode);

        $data = $query->select(
                'non_tender_pengumuman.kd_nontender',
                'non_tender_pengumuman.nama_paket',
                'non_tender_pengumuman.status_nontender',
                'non_tender_pengumuman.hps',
                'satkers.nama_satker',
                DB::raw('COALESCE(non_tender_contract.nilai_pdn_kontrak, non_tender_selesai.nilai_pdn_kontrak, 0) as nilai_pdn_kontrak'),
                DB::raw('COALESCE(non_tender_contract.nilai_umk_kontrak, non_tender_selesai.nilai_umk_kontrak, 0) as nilai_umk_kontrak')
            )
            ->groupBy([
                'non_tender_pengumuman.kd_nontender',
                'non_tender_pengumuman.nama_paket',
                'non_tender_pengumuman.status_nontender',
                'non_tender_pengumuman.hps',
                'satkers.nama_satker',
                'non_tender_contract.nilai_pdn_kontrak',
                'non_tender_selesai.nilai_pdn_kontrak',
                'non_tender_contract.nilai_umk_kontrak',
                'non_tender_selesai.nilai_umk_kontrak'
            ])
            ->orderByRaw("
                CASE 
                    WHEN non_tender_pengumuman.status_nontender = 'Berlangsung' THEN 0
                    WHEN non_tender_pengumuman.status_nontender = 'Selesai' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('non_tender_pengumuman.nama_paket', 'asc')
            ->paginate($perPage)
            ->appends([
                'code' => $code,
                'name' => $name,
                'kd_satker' => $satkerCode,
                'year' => $year,
                'category' => $categoryParam,
                'status_nontender' => $status,
                'per_page' => $perPage,
                'page' => $request->input('page', 1),
            ]);

        return response()->json([
            'html' => view('components.tables.nontender-rows', compact('data'))->render(),
            'pagination' => $data->links('pagination::bootstrap-4')->toHtml(),
            'totalData' => $data->total(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
        ]);
    }
    
public function viewPdf(Request $request)
{
    return $this->generateNonTenderPdf($request, 'view');
}

public function downloadPdf(Request $request)
{
    return $this->generateNonTenderPdf($request, 'download');
}
private function generateNonTenderPdf(Request $request, $mode = 'view')
        {
            // Prioritaskan parameter 'end' jika ada
            $endParam = $request->input('end');
            if ($endParam) {
                try {
                    $endDate = Carbon::createFromFormat('Y-m-d', $endParam)->endOfDay();
                    $year = $endDate->year;
                    $month = $endDate->month;
                    $day = $endDate->day;
                } catch (\Exception $e) {
                    $endDate = now()->endOfDay();
                    $year = $endDate->year;
                    $month = 'ALL';
                    $day = 'ALL';
                }
            } else {
                $year = $request->input('year') ?? now()->year;
                $month = $request->input('month') ?? 'ALL';
                $day = $request->input('day') ?? 'ALL';
        
                // Hitung endDate sesuai kombinasi filter
                if ($month !== 'ALL') {
                    if ($day !== 'ALL') {
                        $endDate = Carbon::createFromDate($year, $month, $day)->endOfDay();
                    } else {
                        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
                    }
                } else {
                    $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();
                }
            }
        
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        
            $raw = DB::table('non_tender_pengumuman as p')
                ->leftJoin('non_tender_contract as c', 'p.kd_nontender', '=', 'c.kd_nontender')
                ->leftJoin('non_tender_selesai as s', 'p.kd_nontender', '=', 's.kd_nontender')
                ->select(
                    'p.nama_satker',
                    'p.jenis_pengadaan',
                    'p.pagu',
                    'p.hps',
                    'p.status_nontender',
                    DB::raw('COALESCE(c.nilai_kontrak, s.nilai_kontrak, 0) as nilai_terkontrak')
                )
                ->where('p.kd_klpd', 'D264')
                ->whereBetween('p.tgl_buat_paket', [$startDate, $endDate])
                ->whereIn('p.status_nontender', ['Selesai', 'Berlangsung'])
                ->get();
        
            $satkers = StrukturAnggaran::where('kd_klpd', 'D264')
                ->where('tahun_anggaran', $year)
                ->pluck('nama_satker')
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        
            $data = [];
            $total = [
                'package_count' => 0,
                'constructions' => 0,
                'consultations' => 0,
                'goods' => 0,
                'services' => 0,
                'pagu' => 0,
                'hps' => 0,
                'nilai_terkontrak' => 0,
                'efficiency' => 0,
            ];
        
            foreach ($satkers as $nama) {
                $data[$nama] = array_merge(['name' => $nama], array_fill_keys(array_keys($total), 0));
            }
        
            foreach ($raw as $value) {
                $satker = $value->nama_satker;
                if (!isset($data[$satker])) continue;
        
                $data[$satker]['package_count']++;
                $total['package_count']++;
        
                $category = getCategory($value->jenis_pengadaan);
                if ($category && isset($data[$satker][$category])) {
                    $data[$satker][$category]++;
                    $total[$category]++;
                }
        
                $data[$satker]['pagu'] += $value->pagu;
                $total['pagu'] += $value->pagu;
        
                $data[$satker]['hps'] += $value->hps;
                $total['hps'] += $value->hps;
        
                $data[$satker]['nilai_terkontrak'] += $value->nilai_terkontrak;
                $total['nilai_terkontrak'] += $value->nilai_terkontrak;
        
                $efficiency = $value->pagu - $value->nilai_terkontrak;
                $data[$satker]['efficiency'] += $efficiency;
                $total['efficiency'] += $efficiency;

                $status = $value->status_nontender;
                $data[$satker]['status_list'][] = $status;
                
                // Inisialisasi array count jika belum ada
                if (!isset($data[$satker]['status_count'])) {
                    $data[$satker]['status_count'] = [];
                }
                if (!isset($data[$satker]['status_count'][$status])) {
                    $data[$satker]['status_count'][$status] = 0;
                }
                $data[$satker]['status_count'][$status]++;
                
                
            }
        
            $finalData = array_values($data);
        
            $title = "REALISASI PAKET NON TENDER\nOPD PROVINSI LAMPUNG\nTAHUN ANGGARAN {$year} S.D TANGGAL " . strtoupper($endDate->translatedFormat('d F Y'));
        
            $html2pdf = new Html2Pdf('L', 'A2', 'en', true, 'UTF-8', [10, 10, 10, 10]);
            $view = auth()->user()->role_id == 1 ? 'non-tender.realization' : 'users.non-tender.realization';
        
            $render = view($view, [
                'data' => $finalData,
                'total' => $total,
                'title' => $title,
                'month' => $month,
                'day' => $day,
                'year' => $year,
            ]);
        
            $html2pdf->pdf->SetAutoPageBreak(true, 10);
            $html2pdf->writeHTML($render);
        
            return $mode === 'download'
                ? $html2pdf->output("realisasi_non_tender_{$year}.pdf", 'D')
                : $html2pdf->output();
        }
        

}