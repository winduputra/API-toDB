<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTenderPengumuman extends Model
{
    protected $table = 'non_tender_pengumuman';

    protected $fillable = [
        'tahun_anggaran', 'kd_klpd', 'nama_klpd', 'jenis_klpd', 'kd_satker', 'kd_satker_str', 'nama_satker',
        'lls_id', 'kd_lpse', 'nama_lpse', 'kd_nontender', 'kd_pkt_dce', 'kd_rup', 'nama_paket',
        'pagu', 'hps', 'sumber_dana', 'mak', 'kualifikasi_paket', 'jenis_pengadaan', 'mtd_pemilihan',
        'kontrak_pembayaran', 'status_nontender', 'versi_nontender', 'ket_diulang', 'ket_ditutup',
        'tgl_buat_paket', 'tgl_kolektif_kolegial', 'tgl_pengumuman_nontender',
        'nip_nama_ppk', 'nip_nama_pokja', 'nip_nama_pp', 'url_lpse', 'repeat_order'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return ['kd_nontender' => $data['kd_nontender'] ?? null];
    }
}

