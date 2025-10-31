<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_anggaran',
        'kd_klpd', 'nama_klpd', 'jenis_klpd',
        'kd_satker', 'kd_satker_str', 'nama_satker',
        'kd_rup', 'nama_paket', 'pagu',
        'kd_metode_pengadaan', 'metode_pengadaan',
        'kd_jenis_pengadaan', 'jenis_pengadaan',
        'status_pradipa', 'status_pdn', 'status_ukm', 'alasan_non_ukm',
        'status_konsolidasi', 'tipe_paket', 'kd_rup_swakelola', 'kd_rup_lokal',
        'volume_pekerjaan', 'urarian_pekerjaan', 'spesifikasi_pekerjaan',
        'tgl_awal_pemilihan', 'tgl_akhir_pemilihan',
        'tgl_awal_kontrak', 'tgl_akhir_kontrak',
        'tgl_awal_pemanfaatan', 'tgl_akhir_pemanfaatan',
        'tgl_buat_paket', 'tgl_pengumuman_paket',
        'nip_ppk', 'nama_ppk', 'username_ppk',
        'status_aktif_rup', 'status_delete_rup', 'status_umumkan_rup',
        'status_dikecualikan', 'alasan_dikecualikan',
        'tahun_pertama', 'kode_rup_tahun_pertama',
        'nomor_kontrak',
        'spp_aspek_ekonomi', 'spp_aspek_sosial', 'spp_aspek_lingkungan',
        '_event_date'
    ];

    protected $table = 'penyedias'; // eksplisit
}
