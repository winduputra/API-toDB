<?php

use App\Models\NonTenderPengumuman;
use App\Models\TenderPengumumanData;
use App\Models\Setting;
use App\Models\Tender;
use App\Services\HelperService;
use Carbon\Carbon;

function moneyFormat($number) {
    return HelperService::moneyFormat($number);
}

function getMonthName($monthNumber) {
    $months = [
        'januari', 'februari', 'maret', 'april',
        'mei', 'juni', 'juli', 'agustus',
        'september', 'oktober', 'november', 'desember',
    ];

    $monthIndex = intval($monthNumber) - 1;

    if( $monthIndex < 0 ) {
        return $monthNumber;
    }
    return $months[$monthIndex];
}

function getMonthNameUpper($monthNumber) {
    $name = getMonthName($monthNumber);
    return strtoupper($name);
}

function getIndonesianDate($date) {
    $exploded = explode("-", $date);
    if( count($exploded) != 3 ) {
        return $date;
    }
    $year = $exploded[0];
    $month = getMonthName($exploded[1]);
    $day = $exploded[2];
    return $day . " " . ucwords($month) . " " . $year;

}

function getCurrentDate() {
    return getIndonesianDate(Carbon::now()->addHours(7)->format("Y-m-d H:i:s"));
}

function getCurrentDateTime() {
    return Carbon::now()->addHours(7)->format("Y-m-d H:i:s");
}

function getCategoryNonTender($category) {
    $category = strtolower($category);
    if (strpos($category, "barang") !== false) return "goods";
    if (strpos($category, "pekerjaan konstruksi") !== false) return "constructions";
    if (strpos($category, "konsul") !== false) return "consultations";
    if (strpos($category, "lainnya") !== false) return "services";
    return null;
}

function getCategoryTender($category) {
    $category = strtolower($category);
    if (str_contains($category, 'konstruksi') && str_contains($category, 'konsult')) {
        return 'consultations';
    }
    if (str_contains($category, 'konstruksi')) {
        return 'constructions';
    }
    if (str_contains($category, 'konsult')) {
        return 'consultations';
    }
    if (str_contains($category, 'lainnya')) {
        return 'services';
    }
    return 'others';
}

function getNonTenderCount($filters = [])
{
    $tahun = $filters['year'] ?? date('Y');
    $kd_satker_str = $filters['kd_satker'] ?? null;

    $query = NonTenderPengumuman::where('kd_klpd', 'D264')
        ->whereIn('status_nontender', ['Selesai', 'Berlangsung'])
        ->where('tahun_anggaran', $tahun);

    if (!empty($kd_satker_str)) {
        $query->where('kd_satker_str', $kd_satker_str);
    }
    if (!empty($filters['code'])) {
        $query->where('kd_nontender', 'like', '%' . $filters['code'] . '%');
    }
    if (!empty($filters['name'])) {
        $query->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
    }
    if (!empty($filters['category'])) {
        $query->where('jenis_pengadaan', 'like', '%' . $filters['category'] . '%');
    }

    return $query->count();
}

function getTenderCount($filters = [])
{
    $tahun = $filters['year'] ?? date('Y');
    $kd_satker_str = $filters['kd_satker'] ?? null;

    $query = TenderPengumumanData::where('kd_klpd', 'D264')
        ->whereIn('status_tender', ['Selesai', 'Berlangsung'])
        ->where('tahun', $tahun);

    if (!empty($kd_satker_str)) {
        $query->where('kd_satker_str', $kd_satker_str);
    }
    if (!empty($filters['code'])) {
        $query->where('kd_tender', 'like', '%' . $filters['code'] . '%');
    }
    if (!empty($filters['name'])) {
        $query->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
    }
    if (!empty($filters['category'])) {
        $query->where('jenis_pengadaan', 'like', '%' . $filters['category'] . '%');
    }

    return $query->count();
}

function getBelaCount($filters = [])
{
    $tahun = $filters['year'] ?? date('Y');
    $kd_satker = null;

    // Cek filter kd_satker (cari di tabel Satker berdasarkan kd_satker_str)
    if (!empty($filters['kd_satker'])) {
        $satker = \App\Models\Satker::where('kd_satker_str', $filters['kd_satker'])->first();
        if ($satker) {
            $kd_satker = $satker->kd_satker;
        }
    }

    // Query hanya status verif "verified"
    $query = \App\Models\TokoDaring::where('tahun', $tahun)
        ->where('status_verif', 'verified');

    if (!empty($filters['code'])) {
        $query->where('kode', 'like', '%' . $filters['code'] . '%');
    }
    if (!empty($filters['name'])) {
        $query->where('nama_paket', 'like', '%' . $filters['name'] . '%');
    }
    if (!empty($kd_satker)) {
        $query->where('kd_satker', $kd_satker);
    }

    return $query->count();
}

function getEkatalogCount($filters = [])
{
    $tahun = $filters['year'] ?? date('Y');
    $kd_satker = null;

    if (!empty($filters['kd_satker'])) {
        $satker = \App\Models\Satker::where(function($q) use($filters) {
            $q->where('kd_satker', $filters['kd_satker'])
              ->orWhere('kd_satker_str', $filters['kd_satker']);
        })->first();

        if ($satker) {
            $kd_satker = $satker->kd_satker;
            $nama_satker = $satker->nama_satker;
        } else {
            $kd_satker = $filters['kd_satker'];
            $nama_satker = $filters['kd_satker'];
        }
    }

    $v5 = \App\Models\EkatalogV5Paket::where('tahun_anggaran', $tahun);

    if (!empty($kd_satker)) {
        $v5->where('satker_id', $kd_satker);
    }
    if (!empty($filters['code'])) {
        $v5->where('kd_paket', 'like', '%' . $filters['code'] . '%');
    }
    if (!empty($filters['name'])) {
        $v5->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
    }
    if (!empty($filters['status'])) {
        $v5->where('status', $filters['status']);
    }

    $v6 = \App\Models\EkatalogV6Paket::where('tahun_anggaran', $tahun);

    if (!empty($kd_satker) || !empty($nama_satker)) {
        $v6->where(function($q) use ($kd_satker, $nama_satker) {
            if (!empty($nama_satker)) {
                $q->where('nama_satker', $nama_satker);
            } else if (!empty($kd_satker)) {
                $q->where('nama_satker', $kd_satker);
            }
        });
    }
    if (!empty($filters['code'])) {
        $v6->where('kd_paket', 'like', '%' . $filters['code'] . '%');
    }
    if (!empty($filters['name'])) {
        $v6->whereRaw('LOWER(nama_paket) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
    }
    if (!empty($filters['status'])) {
        $v6->where('status', $filters['status']);
    }

    $v5_count = $v5->select('kd_paket')->groupBy('kd_paket')->get()->count();
    $v6_count = $v6->select('kd_paket')->groupBy('kd_paket')->get()->count();

    return $v5_count + $v6_count;

   
    
}
if (!function_exists('getCategory')) {
    /**
     * Mengambil kategori umum dari jenis pengadaan.
     * Otomatis menyesuaikan untuk Tender dan Non Tender.
     *
     * @param string $category
     * @param string|null $tipe ('tender' atau 'nontender') jika ingin spesifik
     * @return string|null
     */
    function getCategory($category, $tipe = null)
    {
        $category = strtolower($category);

        // Jika tipe ditentukan secara eksplisit
        if ($tipe === 'nontender') {
            if (str_contains($category, 'barang')) return 'goods';
            if (str_contains($category, 'pekerjaan konstruksi')) return 'constructions';
            if (str_contains($category, 'konsul')) return 'consultations';
            if (str_contains($category, 'lainnya')) return 'services';
            return null;
        }

        if ($tipe === 'tender') {
            if (str_contains($category, 'konstruksi') && str_contains($category, 'konsult')) {
                return 'consultations';
            }
            if (str_contains($category, 'konstruksi')) return 'constructions';
            if (str_contains($category, 'konsult')) return 'consultations';
            if (str_contains($category, 'lainnya')) return 'services';
            return 'others';
        }

        // Default (fallback untuk Non Tender)
        if (str_contains($category, 'barang')) return 'goods';
        if (str_contains($category, 'konstruksi')) return 'constructions';
        if (str_contains($category, 'konsul')) return 'consultations';
        if (str_contains($category, 'lainnya')) return 'services';
        return 'others';
    }
}

if (!function_exists('format_hps_pagu')) {

    function format_hps_pagu($number)
    {
        if ($number === null || $number === '' || $number === false) {
            return '-';
        }
        return number_format($number, 2, ',', '.');
    }
}
