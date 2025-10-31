<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTenderSchedule extends Model
{
    protected $table = 'non_tender_schedules';

    protected $fillable = [
        'tahun_anggaran', 'kd_klpd', 'kd_satker', 'kd_satker_str', 'kd_lpse', 'kd_nontender',
        'kd_tahapan', 'nama_tahapan', 'kd_akt', 'nama_akt', 'tgl_awal', 'tgl_akhir', '_event_date'
    ];

    public $timestamps = true;

    public static function uniqueKeys($data)
    {
        return [
            'kd_nontender' => $data['kd_nontender'] ?? null,
            'kd_tahapan' => $data['kd_tahapan'] ?? null
        ];
    }
}
