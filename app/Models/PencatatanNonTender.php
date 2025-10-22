<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanNonTender extends Model
{
    protected $table = 'non_tender_pencatatan';

    protected $fillable = [
        'tahun_anggaran', 'kd_klpd', 'nama_klpd', 'jenis_klpd', 'kd_satker', 'kd_satker_str',
        'nama_satker', 'kd_lpse', 'kd_nontender_pct', 'kd_pkt_dce', 'kd_rup', 'nama_paket',
        'pagu', 'total_realisasi', 'nilai_pdn_pct', 'nilai_umk_pct', 'sumber_dana', 'uraian_pekerjaan'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return ['kd_nontender_pct' => $data['kd_nontender_pct'] ?? null];
    }
}
