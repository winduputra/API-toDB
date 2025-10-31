<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderParticipant extends Model
{
    use HasFactory;

    protected $fillable     = [
        "kd_tender",
        "kd_lpse",
        "kd_peserta",
        "kd_penyedia",
        "nama_penyedia",
        "npwp_penyedia",
        "nilai_penawaran",
        "nilai_terkoreksi",
        "pemenang",
        "pemenang_terverifikasi",
        "alasan",
    ];
    
}
