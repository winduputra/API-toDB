<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppbjData extends Model
{
    protected $table = 'sppbj_data';

    protected $fillable = [
        'kd_tender',
        'nama_paket',
        'nama_klpd',
        'status_tender',
        'pagu',
        'hps',
        'nilai_pdn_kontrak',
        'nilai_umk_kontrak',
        'nilai_kontrak',
        'besar_pembayaran',
        'tahun',
        'sumber_api',
        'kd_satker',      
        'nama_satker',     
    ];

    protected $casts = [
        'pagu' => 'decimal:2',
        'hps' => 'decimal:2',
        'nilai_pdn_kontrak' => 'decimal:2',
        'nilai_umk_kontrak' => 'decimal:2',
        'nilai_kontrak' => 'decimal:2',
        'besar_pembayaran' => 'decimal:2',
        'tahun' => 'string',
    ];
}
