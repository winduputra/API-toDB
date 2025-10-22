<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokoDaring extends Model
{
    protected $table = 'toko_darings';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'kd_klpd',
        'nama_klpd',
        'kd_satker',
        'nama_satker',
        'order_id',
        'order_desc',
        'valuasi',
        'kategori',
        'metode_bayar',
        'tanggal_transaksi',
        'marketplace',
        'merchant_name',
        'jenis_transaksi',
        'kota_kab',
        'provinsi',
        'nama_pemesan',
        'status_verif',
        'sumber_data',
        'status_konfirmasi_ppmse',
        'keterangan_ppmse',
    ];
}
