<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkatalogV6Paket extends Model
{
    use HasFactory;

    protected $table = 'ekatalog_v6_pakets';

    protected $fillable = [
        'tahun_anggaran',
        'jenis_instansi',
        'nama_instansi',
        'nama_satker',
        'kd_klpd',
        'kd_satker_str',
        'kd_paket',
        'kd_rup',
        'rup_nama_pkt',
        'sumber_dana',
        'mak',
        'kd_penyedia_ppn',
        'jml_jenis_produk',
        'jml_produk',
        'ongkir',
        'total_harga',
        'tgl_order',
        'status_pkt',
        'status_pengiriman'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return ['kd_paket' => $data['kd_paket'] ?? null];
    }
}
