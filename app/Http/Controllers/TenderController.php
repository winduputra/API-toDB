<?php

namespace App\Http\Controllers;

use App\Models\TenderPengumumanData;
use App\Models\StrukturAnggaran;
use Carbon\Carbon;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Satker; 


class TenderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input parameter
        $year          = $request->input('year', date('Y'));
        $satkerCode    = $request->input('kd_satker');
        $code          = $request->input('code');
        $name          = $request->input('name');
        $status        = $request->input('status_tender', '');
        $categoryParam = $request->input('category');
        $perPage       = $request->input('per_page', 30);

        // Status list
        $statusList = [
            '' => 'Semua Status',
            'Berlangsung' => 'Berlangsung',
            'Selesai' => 'Selesai',
        ];

        // Ambil daftar Satker unik
        $satkers = Satker::where('kd_klpd', 'D264')
            ->where('kd_satker', '!=', '350504')
            ->select('kd_satker', 'kd_satker_str', 'nama_satker')
            ->orderBy('nama_satker')
            ->get()
            ->unique('kd_satker_str')
            ->values();

        // Query utama Tender
        $query = TenderPengumumanData::query()
            ->leftJoin('tender_selesai_data', 'tender_pengumuman_data.kd_tender', '=', 'tender_selesai_data.kd_tender')
            ->leftJoin('kontrak_data', 'tender_pengumuman_data.kd_tender', '=', 'kontrak_data.kd_tender')
            ->leftJoin('satkers', 'tender_pengumuman_data.kd_satker_str', '=', 'satkers.kd_satker_str')
            ->where('tender_pengumuman_data.kd_satker', '!=', '350504')
            ->where('tender_pengumuman_data.tahun', $year)
            ->where('tender_pengumuman_data.kd_klpd', 'D264');

        // Filter status
        if ($status) {
            $query->where('tender_pengumuman_data.status_tender', $status);
        } else {
            $query->whereIn('tender_pengumuman_data.status_tender', ['Selesai', 'Berlangsung']);
        }

        if ($categoryParam) {
            $query->where('tender_pengumuman_data.jenis_pengadaan', 'like', "%$categoryParam%");
        }
        if ($code) {
            $query->where('tender_pengumuman_data.kd_tender', 'like', "%$code%");
        }
        if ($name) {
            $query->whereRaw('LOWER(tender_pengumuman_data.nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
        }
        if ($satkerCode) {
            $query->where('tender_pengumuman_data.kd_satker_str', $satkerCode);
        }

        // Urutkan berdasarkan status saja, tanpa nama paket
        $data = $query->select(
                'tender_pengumuman_data.kd_tender',
                'tender_pengumuman_data.kd_klpd',
                'tender_pengumuman_data.kd_satker',
                'tender_pengumuman_data.kd_satker_str',
                'tender_pengumuman_data.tahun',
                'tender_pengumuman_data.nama_paket',
                'tender_pengumuman_data.status_tender',
                'tender_pengumuman_data.hps',
                'tender_pengumuman_data.jenis_pengadaan',
                'tender_pengumuman_data.pagu',
                'satkers.nama_satker',
                DB::raw('COALESCE(kontrak_data.nilai_pdn_kontrak, tender_selesai_data.nilai_pdn_kontrak, 0) as nilai_pdn_kontrak'),
                DB::raw('COALESCE(kontrak_data.nilai_umk_kontrak, tender_selesai_data.nilai_umk_kontrak, 0) as nilai_umk_kontrak')
            )
            ->groupBy([
                'tender_pengumuman_data.kd_tender',
                'tender_pengumuman_data.kd_klpd',
                'tender_pengumuman_data.kd_satker',
                'tender_pengumuman_data.kd_satker_str',
                'tender_pengumuman_data.tahun',
                'tender_pengumuman_data.nama_paket',
                'tender_pengumuman_data.status_tender',
                'tender_pengumuman_data.hps',
                'tender_pengumuman_data.jenis_pengadaan',
                'tender_pengumuman_data.pagu',
                'satkers.nama_satker',
                'kontrak_data.nilai_pdn_kontrak',
                'tender_selesai_data.nilai_pdn_kontrak',
                'kontrak_data.nilai_umk_kontrak',
                'tender_selesai_data.nilai_umk_kontrak',
            ])
            ->orderByRaw("CASE 
                WHEN tender_pengumuman_data.status_tender = 'Berlangsung' THEN 0
                WHEN tender_pengumuman_data.status_tender = 'Selesai' THEN 1
                ELSE 2
            END")
            ->paginate($perPage)
            ->appends([
                'code' => $code,
                'name' => $name,
                'kd_satker' => $satkerCode,
                'year' => $year,
                'category' => $categoryParam,
                'status_tender' => $status,
                'per_page' => $perPage,
            ]);

        // Tahun
        $years = TenderPengumumanData::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();

        // Kategori
        $categories = TenderPengumumanData::whereYear('tgl_pengumuman_tender', $year)
            ->select('jenis_pengadaan')
            ->distinct()
            ->pluck('jenis_pengadaan')
            ->toArray();

        // Jumlah per kategori
        $categoriesCount = [];
        foreach ($categories as $category) {
            $catQuery = TenderPengumumanData::where('tahun', $year)
                ->where('kd_klpd', 'D264')
                ->where('jenis_pengadaan', $category);
            if ($status) $catQuery->where('status_tender', $status);
            else $catQuery->whereIn('status_tender', ['Selesai', 'Berlangsung']);
            if ($code) $catQuery->where('kd_tender', 'like', "%$code%");
            if ($name) $catQuery->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
            if ($satkerCode) $catQuery->where('kd_satker_str', $satkerCode);

            $categoriesCount[] = $catQuery->count();
        }

        // Total jumlah filtered dan full
        $total = $data->total();
        $totalFullQuery = TenderPengumumanData::where('tahun', $year)
            ->where('kd_klpd', 'D264');
        if ($status) $totalFullQuery->where('status_tender', $status);
        else $totalFullQuery->whereIn('status_tender', ['Selesai', 'Berlangsung']);
        $totalFull = $totalFullQuery->count();

        $url = url()->full();
        if (!str_contains($url, "?")) $url .= "?";

        $view = (auth()->user()->role_id == 2)
            ? 'users.tender.index-lte'
            : 'tender.index-lte';

        return view($view, compact(
            'satkers', 'years', 'data', 'total', 'totalFull',
            'code', 'name', 'year', 'satkerCode',
            'categories', 'categoriesCount', 'url', 'categoryParam', 'status', 'statusList'
        ));
    }

    public function search(Request $request)
    {
        $code          = $request->input('code');
        $name          = $request->input('name');
        $year          = $request->input('year', date('Y'));
        $satkerCode    = $request->input('kd_satker');
        $categoryParam = $request->input('category');
        $status        = $request->input('status_tender', ''); // Tambahan filter status!
        $perPage       = 30;

        $query = TenderPengumumanData::query()
            ->leftJoin('tender_selesai_data', 'tender_pengumuman_data.kd_tender', '=', 'tender_selesai_data.kd_tender')
            ->leftJoin('kontrak_data', 'tender_pengumuman_data.kd_tender', '=', 'kontrak_data.kd_tender')
            ->leftJoin('satkers', 'tender_pengumuman_data.kd_satker_str', '=', 'satkers.kd_satker_str')
            ->where('tender_pengumuman_data.kd_satker', '!=', '350504')
            ->where('tender_pengumuman_data.tahun', $year)
            ->where('tender_pengumuman_data.kd_klpd', 'D264');

        // Filter status
        if ($status) {
            $query->where('tender_pengumuman_data.status_tender', $status);
        } else {
            $query->whereIn('tender_pengumuman_data.status_tender', ['Selesai', 'Berlangsung']);
        }

        if ($categoryParam) {
            $query->where('tender_pengumuman_data.jenis_pengadaan', 'like', "%$categoryParam%");
        }
        if ($code) {
            $query->where('tender_pengumuman_data.kd_tender', 'like', "%$code%");
        }
        if ($name) {
            $query->whereRaw('LOWER(tender_pengumuman_data.nama_paket) LIKE ?', ['%' . strtolower($name) . '%']);
        }
        if ($satkerCode) {
            $query->where('tender_pengumuman_data.kd_satker_str', $satkerCode);
        }

        $data = $query->select(
            'tender_pengumuman_data.kd_tender',
            'tender_pengumuman_data.nama_paket',
            'tender_pengumuman_data.status_tender',
            'tender_pengumuman_data.hps',
            'satkers.nama_satker',
            DB::raw('COALESCE(kontrak_data.nilai_pdn_kontrak, tender_selesai_data.nilai_pdn_kontrak, 0) as nilai_pdn_kontrak'),
            DB::raw('COALESCE(kontrak_data.nilai_umk_kontrak, tender_selesai_data.nilai_umk_kontrak, 0) as nilai_umk_kontrak')
        )
        ->groupBy(
            'tender_pengumuman_data.kd_tender',
            'tender_pengumuman_data.nama_paket',
            'tender_pengumuman_data.status_tender',
            'tender_pengumuman_data.hps',
            'satkers.nama_satker',
            'kontrak_data.nilai_pdn_kontrak',
            'tender_selesai_data.nilai_pdn_kontrak',
            'kontrak_data.nilai_umk_kontrak',
            'tender_selesai_data.nilai_umk_kontrak'
        )
        ->orderBy('tender_pengumuman_data.status_tender', 'asc')  // Pengurutan hanya berdasarkan status tender
        ->paginate($perPage);

        return response()->json([
            'html'        => view('components.tables.tender-rows', compact('data'))->render(),
            'pagination'  => $data->links('pagination::bootstrap-4')->toHtml(),
            'totalData'   => $data->total(),
            'currentPage' => $data->currentPage(),
            'lastPage'    => $data->lastPage(),
        ]);
    }



      
        public function viewPdf(Request $request)
        {
            return $this->generateTenderPdf($request, 'view');
        }

        public function downloadPdf(Request $request)
        {
            return $this->generateTenderPdf($request, 'download');
        }

        private function generateTenderPdf(Request $request, $mode = 'view')
        {
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
        
                if ($month !== 'ALL' && $day !== 'ALL') {
                    $endDate = Carbon::create($year, $month, $day)->endOfDay();
                } elseif ($month !== 'ALL') {
                    $endDate = Carbon::create($year, $month)->endOfMonth()->endOfDay();
                } else {
                    $endDate = now()->endOfDay();
                }
            }
        
            
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
        
            // Ambil data dari DB
            $raw = DB::table('tender_pengumuman_data as p')
                ->leftJoin('kontrak_data as c', 'p.kd_tender', '=', 'c.kd_tender')
                ->leftJoin('tender_selesai_data as s', 'p.kd_tender', '=', 's.kd_tender')
                ->select(
                    'p.nama_satker',
                    'p.jenis_pengadaan',
                    'p.pagu',
                    'p.hps',
                    'p.status_tender',
                    DB::raw('COALESCE(c.nilai_kontrak, s.nilai_kontrak, 0) as nilai_terkontrak')
                )
                ->where('p.kd_klpd', 'D264')
                ->whereBetween('p.tgl_buat_paket', [$startDate, $endDate])
                ->whereIn('p.status_tender', ['Selesai', 'Berlangsung'])
                ->get();
        
            // Ambil daftar satker
            $satkers = StrukturAnggaran::where('kd_klpd', 'D264')
                ->where('tahun_anggaran', $year)
                ->pluck('nama_satker')
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        
            // Inisialisasi
            $data = [];
            $total = [
                'package_count' => 0,
                'constructions' => 0,
                'consultations' => 0,
                'goods' => 0,
                'services' => 0,
                'others' => 0, // ← ini penting
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

                $status = $value->status_tender;
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
        
            // Judul laporan
            $title = "REALISASI PAKET TENDER\nOPD PROVINSI LAMPUNG\nTAHUN ANGGARAN {$year} S.D TANGGAL " . strtoupper($endDate->translatedFormat('d F Y'));
        
            // Generate PDF
            $html2pdf = new Html2Pdf('L', 'A2', 'en', true, 'UTF-8', [10, 10, 10, 10]);


            $view = auth()->user()->role_id == 1 ? 'tender.realization' : 'users.tender.realization';
        
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
                ? $html2pdf->output("realisasi_tender_{$year}.pdf", 'D')
                : $html2pdf->output();
        }
    }


    
