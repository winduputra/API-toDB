<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturAnggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_anggaran',
        'kd_klpd', 'nama_klpd',
        'kd_satker', 'kd_satker_str', 'nama_satker',
        'belanja_operasi', 'belanja_modal', 'belanja_btt',
        'belanja_non_pengadaan', 'belanja_pengadaan',
        'total_belanja',
    ];

    protected $table = 'struktur_anggarans'; // opsional, agar eksplisit
}
