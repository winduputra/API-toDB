<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTenderSpmk extends Model
{
    protected $table = 'non_tender_spmk';

    protected $fillable = [
        'tahun_anggaran', 'kd_klpd', 'nama_klpd', 'jenis_klpd', 'kd_satker', 'kd_satker_str',
        'nama_satker', 'alamat_satker', 'kd_lpse', 'kd_nontender', 'nama_paket', 'mtd_pengadaan',
        'no_sppbj', 'no_kontrak', 'tgl_kontrak', 'no_spmk_spp', 'tgl_spmk_spp', 'tgl_mulai_pekerjaan',
        'tgl_selesai_pekerjaan', 'waktu_penyelesaian', 'kota_spmk_spp', 'alamat_pengiriman',
        'nip_ppk', 'nama_ppk', 'jabatan_ppk', 'nama_penyedia', 'alamat_penyedia', 'npwp_penyedia',
        'npwp_16_penyedia', 'wakil_sah_penyedia', 'jabatan_wakil_penyedia', 'status_kontrak',
        'tgl_penetapan_status_kontrak', 'alasan_penetapan_status_kontrak', 'apakah_addendum',
        'versi_addendum', 'alasan_addendum', '_event_date'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return ['kd_nontender' => $data['kd_nontender'] ?? null];
    }
}

