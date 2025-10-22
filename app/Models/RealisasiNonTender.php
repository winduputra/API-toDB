<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiNonTender extends Model
{
    protected $table = 'non_tender_realisasi';

    protected $fillable = [
        'tahun_anggaran', 'kd_klpd', 'nama_klpd', 'jenis_klpd', 'kd_satker', 'kd_satker_str',
        'nama_satker', 'kd_lpse', 'nama_lpse', 'kd_nontender_pct', 'kd_paket_dce', 'kd_rup_paket',
        'nama_paket', 'pagu', 'jenis_realisasi', 'no_realisasi', 'tgl_realisasi', 'nilai_realisasi',
        'dok_realisasi', 'ket_realisasi', 'nama_penyedia', 'npwp_penyedia', 'nip_ppk', 'nama_ppk',
        '_event_date'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return [
            'no_realisasi' => $data['no_realisasi'] ?? null,
            'tgl_realisasi' => $data['tgl_realisasi'] ?? null,
        ];
    }
}
