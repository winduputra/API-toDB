<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderSchedule extends Model
{
    use HasFactory;

    protected $fillable     = [
        "kd_lelang",
        "kd_tahapan",
        "tahapan",
        "tanggal_awal",
        "tanggal_akhir",
        "kd_akt",
        "nama_akt",
    ];
}