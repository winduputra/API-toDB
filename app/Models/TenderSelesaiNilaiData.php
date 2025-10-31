<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderSelesaiNilaiData extends Model
{
    protected $table = 'tender_selesai_nilai_data';

    protected $fillable = [
        'kd_tender',
        'kd_paket',
        'kd_rup_paket',
        'nama_paket',

        'kd_klpd',
        'nama_klpd',
        'jenis_klpd',

        'kd_satker',
        'nama_satker',

        'kd_lpse',

        'pagu',
        'hps',
        'nilai_penawaran',
        'nilai_terkoreksi',
        'nilai_negosiasi',
        'nilai_kontrak',
        'nilai_pdn_kontrak',
        'nilai_umk_kontrak',

        'kd_penyedia',
        'nama_penyedia',
        'npwp_penyedia',
        'npwp_16_penyedia',

        'tgl_pengumuman_tender',
        'tgl_penetapan_pemenang',

        'tahun',
        'sumber_api',
    ];
}
