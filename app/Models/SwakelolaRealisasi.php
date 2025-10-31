<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwakelolaRealisasi extends Model
{
    protected $table = 'swakelola_realisasi';

    protected $fillable = [
        'tahun_anggaran',
        'kd_klpd',
        'kd_satker',
        'nama_satker',
        'kd_swakelola_pct',
        'jenis_realisasi',
        'no_realisasi',
        'tgl_realisasi',
        'nilai_realisasi',
        'dok_realisasi',
        'ket_realisasi',
        'nama_pelaksana',
        'npwp_pelaksana',
        'nip_ppk',
        'nama_ppk',
    ];
}
