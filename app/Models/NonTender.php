<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NonTender extends Model
{
    public $timestamps = false;
    protected $table = null; // tidak terikat ke satu tabel

    // Gunakan custom query
    public static function getAllData()
    {
        return DB::table('non_tender_pengumuman')
            ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'pengumuman' as sumber"))
            ->unionAll(
                DB::table('non_tender_selesai')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'selesai' as sumber"))
            )
            ->unionAll(
                DB::table('non_tender_contract')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'contract' as sumber"))
            )
            ->unionAll(
                DB::table('non_tender_spmk')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'spmk' as sumber"))
            )
            ->unionAll(
                DB::table('non_tender_realisasi')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'realisasi' as sumber"))
            )
            ->unionAll(
                DB::table('non_tender_pencatatan')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'pencatatan' as sumber"))
            )
            ->unionAll(
                DB::table('non_tender_schedules')
                    ->select('kd_klpd', 'nama_paket', 'tahun', 'status_tender', DB::raw("'schedules' as sumber"))
            )
            ->get();
    }
}
