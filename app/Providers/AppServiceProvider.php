<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }


    public function boot()
    {
        $nonTenderYears = [];
        $tenderYears = [];

        if (Schema::hasTable('non_tender_pengumuman')) {
            $nonTenderYears = DB::table('non_tender_pengumuman')
                ->selectRaw("DATE_PART('year', tgl_buat_paket) as year")
                ->distinct()
                ->pluck('year')
                ->map(fn($year) => (int) $year)
                ->sortDesc()
                ->values()
                ->toArray();
        }

        if (Schema::hasTable('tender_pengumuman_data')) {
            $tenderYears = DB::table('tender_pengumuman_data')
                ->selectRaw("DATE_PART('year', tgl_buat_paket) as year")
                ->distinct()
                ->pluck('year')
                ->map(fn($year) => (int) $year)
                ->sortDesc()
                ->values()
                ->toArray();
        }

        // Bagikan ke semua view
        View::share([
            'nonTenderYears' => $nonTenderYears,
            'tenderYears' => $tenderYears,
        ]);

    }
}
