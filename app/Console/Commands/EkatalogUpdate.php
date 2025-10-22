<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
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
            $total = count($data);

            foreach ($data as $index => $item) {
                // 🧹 Sanitasi data sebelum disimpan
                $item = $this->sanitizeData($item);

                try {
                    $model::create($item);
                } catch (\Throwable $e) {
                    // Tangani error agar loop tidak berhenti
                    $this->error("⚠️ Gagal simpan baris ke-" . ($index + 1) . " model {$model}: " . $e->getMessage());
                    continue;
                }
            }

            $this->info("✔ Data ({$total}) disimpan untuk model: {$model}");
        } else {
            $this->error("✖ Gagal mengambil data dari {$url}");
        }
    }

    /**
     * Bersihkan data mentah dari API agar sesuai tipe kolom DB
     */
    protected function sanitizeData(array $data): array
    {
        // Bersihkan kd_rup jika ada duplikasi nilai seperti "58488552,58488552"
        if (isset($data['kd_rup']) && is_string($data['kd_rup'])) {
            $parts = array_unique(array_map('trim', explode(',', $data['kd_rup'])));
            $data['kd_rup'] = $parts[0] ?? null;
        }

        // Bersihkan juga kolom lain yang berpotensi numeric tapi dikirim string berganda
        foreach (['total_harga', 'ongkir', 'jml_produk', 'jml_jenis_produk'] as $numericField) {
            if (isset($data[$numericField]) && is_string($data[$numericField])) {
                // Hapus karakter non-digit, kecuali titik desimal
                $data[$numericField] = preg_replace('/[^\d.]/', '', $data[$numericField]);
            }
        }

        // Hilangkan field kosong/null agar tidak menyebabkan QueryException
        return Arr::where($data, fn($v) => $v !== null && $v !== '');
    }
}
