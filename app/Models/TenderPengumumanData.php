<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderPengumumanData extends Model
{
    protected $table = 'tender_pengumuman_data';

    protected $fillable = [
        'kd_tender',
        'kd_pkt_dce',
        'kd_rup',
        'nama_paket',
        'nama_klpd',
        'kd_klpd',
        'jenis_klpd',
        'kd_satker',
        'kd_satker_str',
        'nama_satker',
        'kd_lpse',
        'nama_lpse',
        'pagu',
        'hps',
        'sumber_dana',
        'kualifikasi_paket',
        'jenis_pengadaan',
        'mtd_pemilihan',
        'mtd_evaluasi',
        'mtd_kualifikasi',
        'kontrak_pembayaran',
        'status_tender',
        'tanggal_status',
        'versi_tender',
        'ket_ditutup',
        'ket_diulang',
        'tgl_buat_paket',
        'tgl_kolektif_kolegial',
        'tgl_pengumuman_tender',
        'nip_ppk',
        'nama_ppk',
        'nip_pokja',
        'nama_pokja',
        'lokasi_pekerjaan',
        'url_lpse',
        '_event_date',
        'tahun',
        'sumber_api',
        'nilai_pdn_kontrak',
        'nilai_umk_kontrak',
        'nilai_kontrak',
        'besar_pembayaran',

        
    ];
    
}
