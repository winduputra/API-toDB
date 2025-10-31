<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\TokoDaring;

class TokoDaringUpdate extends Command
{
    protected $signature = 'tokodaring:update';
    protected $description = 'Ambil dan simpan data Toko Daring dari ISB';
    protected $klpd = 'D264';

    public function handle()
    {
        foreach ([2024, 2025] as $tahun) {
            $url = "https://isb.lkpp.go.id/isb-2/api/f9a6ed98-0cee-4d6b-8057-bf8461461dcb/json/9624/Bela-TokoDaringRealisasi/tipe/12:4/parameter/{$this->klpd}:{$tahun}";
            $this->info("🔄 Ambil data Toko Daring {$tahun}...");

            $response = Http::get($url);
            if ($response->successful()) {
                foreach ($response->json() as $item) {
                    TokoDaring::updateOrCreate(
                        ['order_id' => $item['order_id']],
                        $item
                    );
                }
                $this->info("✔ Tahun {$tahun} selesai.");
            } else {
                $this->error("✖ Gagal ambil data tahun {$tahun}");
            }
        }
    }
}
