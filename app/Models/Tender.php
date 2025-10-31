<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    // no nama_satker

    protected $fillable = [
        "tahun_anggaran",
        "kd_klpd",
        "nama_klpd",
        "nama_paket",
        "jenis_klpd",
        "kd_satker",
        "kd_lpse",
        "kd_tender",
        "kd_paket",
        "kd_rup_paket",
        "pagu",
        "hps",
        "nilai_penawaran",
        "nilai_terkoreksi",
        "nilai_negosiasi",
        "nilai_kontrak",
        "ang",
        "kualifikasi_paket",
        "metode_pengadaan",
        "tgl_buat_paket",
        "tgl_pengumuman_tender",
        "tgl_penetapan_pemenang",
        "kd_penyedia",
        "nama_penyedia",
        "npwp_penyedia",
        "mak",
        "nilai_pdn",
        "jenis_pengadaan",
        "mtd_pemilihan",
        "mtd_evaluasi",
        "mtd_kualifikasi",
        "kontrak_pembayaran",
        "kontrak_tahun",
        "jenis_kontrak",
        "nama_status_tender",
        "versi_tender",
        "ket_diulang",
        "ket_ditutup",
        "tgl_kolektif_kolegial",
        "url_lpse",
        "lokasi_pekerjaan",
        "implementation",
        "letter_number",
        "news_number",
        "note",
    ];

    protected $appends  = [
        'satker'
    ];

    public function schedules()
    {
        return $this->hasMany(TenderSchedule::class, 'kd_lelang', 'kd_tender');
    }

    public function participants()
    {
        return $this->hasMany(TenderParticipant::class, 'kd_tender', 'kd_tender');
    }

    public function getCurrentScheduleAttribute()
    {
        $schedule  = $this->schedules()->where('tanggal_awal', '<=', now())->where('tanggal_akhir', '>=', now())->first();
        if( $schedule ) {
            return $schedule->tahapan;
        }
        $schedule  = $this->schedules()->latest()->first();
        if( $schedule ) {
            return $schedule->tahapan;   
        }
        return null;
    }

    public function satker() {
        return $this->belongsTo(Satker::class, 'kd_satker', 'kd_satker_str');
    }

    public function getSatkerAttribute() {
        return $this->satker()->first();
    }
}
