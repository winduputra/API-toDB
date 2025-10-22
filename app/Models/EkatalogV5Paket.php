<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkatalogV5Paket extends Model
{
    use HasFactory;

    protected $table = 'ekatalog_v5_pakets';

    protected $fillable = [
        'tahun_anggaran',
        'kd_klpd',
        'satker_id',
        'nama_satker',
        'alamat_satker',
        'npwp_satker',
        'kd_paket',
        'no_paket',
        'nama_paket',
        'kd_rup',
        'nama_sumber_dana',
        'kode_anggaran',
        'kd_komoditas',
        'kd_produk',
        'kd_penyedia',
        'kd_penyedia_distributor',
        'jml_jenis_produk',
        'kuantitas',
        'harga_satuan',
        'ongkos_kirim',
        'total_harga',
        'kd_user_pokja',
        'no_telp_user_pokja',
        'email_user_pokja',
        'kd_user_ppk',
        'ppk_nip',
        'jabatan_ppk',
        'tanggal_buat_paket',
        'tanggal_edit_paket',
        'deskripsi',
        'status_paket',
        'paket_status_str',
        'catatan_produk',
        'kd_provinsi_wilayah_harga',
        'kd_kabupaten_wilayah_harga'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return [
            'kd_paket' => $data['kd_paket'] ?? null,
            'kd_produk' => $data['kd_produk'] ?? null,
        ];
    }
}
