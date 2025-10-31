<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BapbastData extends Model
{
    protected $table = 'bapbast_data';

    protected $fillable = [
        // Identitas Tender
        'kd_tender',
        'nama_paket',

        // KLPD dan Satker
        'kd_klpd',
        'nama_klpd',
        'jenis_klpd',
        'kd_satker',
        'kd_satker_str',
        'nama_satker',
        'alamat_satker',

        // Status dan jenis pengadaan
        'status_kontrak',
        'jenis_pengadaan',
        'kd_lpse',

        // Dokumen kontrak
        'no_sppbj',
        'no_kontrak',
        'tgl_kontrak',

        // Nilai kontrak
        'nilai_kontrak',
        'nilai_pdn_kontrak',
        'nilai_umk_kontrak',

        // PPK
        'nama_ppk',
        'nip_ppk',
        'jabatan_ppk',
        'no_sk_ppk',
        'jabatan_penandatangan_sk',

        // Penyedia
        'nama_penyedia',
        'alamat_penyedia',
        'npwp_penyedia',
        'npwp_16_penyedia',

        // Wakil penyedia
        'wakil_sah_penyedia',
        'jabatan_wakil_penyedia',

        // BAST & BAP
        'no_bast',
        'tgl_bast',
        'no_bap',
        'tgl_bap',

        // Pembayaran & progres
        'besar_pembayaran',
        'progres_pekerjaan',
        'cara_pembayaran_kontrak',

        // Status kontrak tambahan
        'tgl_penetapan_status_kontrak',
        'alasan_penetapan_status_kontrak',

        // Addendum
        'apakah_addendum',
        'versi_addendum',
        'alasan_addendum',

        // Metadata
        'tahun',
        'sumber_api',
    ];

    protected $casts = [
        'nilai_kontrak' => 'decimal:2',
        'nilai_pdn_kontrak' => 'decimal:2',
        'nilai_umk_kontrak' => 'decimal:2',
        'besar_pembayaran' => 'decimal:2',

        'tgl_kontrak' => 'datetime',
        'tgl_bast' => 'datetime',
        'tgl_bap' => 'datetime',
        'tgl_penetapan_status_kontrak' => 'datetime',

        'progres_pekerjaan' => 'integer',
        'versi_addendum' => 'integer',
        'kd_lpse' => 'integer',
        'tahun' => 'string',
    ];
}
