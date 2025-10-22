<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTenderSelesai extends Model
{
    protected $table = 'non_tender_selesai';

    protected $fillable = [
        'tahun_anggaran', 'lpse_id', 'kd_klpd', 'nama_klpd', 'jenis_klpd', 'kd_satker', 'kd_satker_str',
        'nama_satker', 'kd_lpse', 'nama_lpse', 'kd_nontender', 'kd_pkt_dce', 'kd_rup', 'nama_paket',
        'pagu', 'hps', 'nilai_penawaran', 'nilai_terkoreksi', 'nilai_negosiasi', 'nilai_kontrak',
        'nilai_pdn_kontrak', 'nilai_umk_kontrak', 'sumber_dana', 'mak', 'kualifikasi_paket',
        'kontrak_pembayaran', 'status_nontender', 'tgl_pengumuman_nontender', 'tgl_selesai_nontender',
        'kd_penyedia', 'nama_penyedia', 'npwp_penyedia'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return ['kd_nontender' => $data['kd_nontender'] ?? null];
    }
}
