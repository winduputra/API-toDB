<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\EkatalogV5Paket;
use App\Models\EkatalogV6Paket;

class EkatalogUpdate extends Command
{
    protected $signature = 'ekatalog:update';
    protected $description = 'Ambil dan simpan data e-Katalog V5 (2024–2025) dan V6 (2025 saja)';
    protected $klpd = 'D264';

    public function handle()
    {
        $this->info('🔄 Mengambil data e-Katalog V5 (2024 & 2025)...');

        foreach ([2024, 2025] as $year) {
            $this->fetchAndStore(
                "https://isb.lkpp.go.id/isb-2/api/30fc0faf-22c8-41e9-adcf-8e8e841c9249/json/9610/Ecat-PaketEPurchasing/tipe/4:12/parameter/{$year}:{$this->klpd}",
                EkatalogV5Paket::class
            );
        }

        $this->info('🔄 Mengambil data e-Katalog V6 (2025)...');

        $this->fetchAndStore(
            "https://isb.lkpp.go.id/isb-2/api/a95611fd-9648-452e-bc6a-1c7275ab01f3/json/31035/Ecat-PaketEPurchasingV6/tipe/4:12/parameter/2025:{$this->klpd}",
            EkatalogV6Paket::class
        );

        $this->info('✅ Semua data e-Katalog berhasil diperbarui.');
    }

    protected function fetchAndStore($url, $model)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data as $item) {
                $model::create($item);

            }
            $this->info("✔ Data disimpan untuk model: {$model}");
        } else {
            $this->error("✖ Gagal mengambil data dari {$url}");
        }
    }
}

