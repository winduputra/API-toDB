<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderSelesaiData extends Model
{
    protected $table = 'tender_selesai_data';

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
        'kd_satker',        // ✅ tambahkan
        'nama_satker',      // ✅ tambahkan
    ];
    
}
