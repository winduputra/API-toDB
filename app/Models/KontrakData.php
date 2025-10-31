<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakData extends Model
{
    protected $table = 'kontrak_data';

    protected $fillable = [
        'kd_tender',
        'nama_paket',
        'kd_klpd',
        'nama_klpd',
        'jenis_klpd',
        'kd_satker',
        'kd_satker_str',
        'nama_satker',
        'alamat_satker',
        'kd_lpse',
        'lingkup_pekerjaan',
        'no_sppbj',
        'no_kontrak',
        'tgl_kontrak',
        'tgl_kontrak_awal',
        'tgl_kontrak_akhir',
        'kota_kontrak',
        'nip_ppk',
        'nama_ppk',
        'jabatan_ppk',
        'no_sk_ppk',
        'nama_penyedia',
        'kd_penyedia',
        'npwp_penyedia',
        'npwp_16_penyedia',
        'bentuk_usaha_penyedia',
        'tipe_penyedia',
        'anggota_kso',
        'wakil_sah_penyedia',
        'jabatan_wakil_penyedia',
        'nama_rek_bank',
        'no_rek_bank',
        'nama_pemilik_rek_bank',
        'nilai_kontrak',
        'nilai_pdn_kontrak',
        'nilai_umk_kontrak',
        'alasan_ubah_nilai_kontrak',
        'alasan_nilai_kontrak_10_persen',
        'jenis_kontrak',
        'informasi_lainnya',
        'status_kontrak',
        'tgl_penetapan_status_kontrak',
        'alasan_penetapan_status_kontrak',
        'apakah_addendum',
        'versi_addendum',
        'alasan_addendum',
        'tahun',
        'sumber_api',
    ];

    protected $casts = [
        'tgl_kontrak' => 'datetime',
        'tgl_kontrak_awal' => 'datetime',
        'tgl_kontrak_akhir' => 'datetime',
        'tgl_penetapan_status_kontrak' => 'datetime',
        'nilai_kontrak' => 'decimal:2',
        'nilai_pdn_kontrak' => 'decimal:2',
        'nilai_umk_kontrak' => 'decimal:2',
        'versi_addendum' => 'integer',
        'kd_lpse' => 'integer',
        'kd_penyedia' => 'integer',
    ];
}
