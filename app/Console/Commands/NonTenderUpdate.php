<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\NonTenderPengumuman;
use App\Models\NonTenderSelesai;
use App\Models\PencatatanNonTender;
use App\Models\RealisasiNonTender;
use App\Models\NonTenderBapbast;
use App\Models\NonTenderSpmk;
use App\Models\NonTenderSchedule;
use App\Models\NonTenderKontrak;

class NonTenderUpdate extends Command
{
    protected $signature = 'nontender:update';

    protected $description = 'Ambil dan simpan data Non Tender dari semua endpoint untuk tahun 2024 dan 2025';

    protected $lpse = 121;
    protected $years = [2024, 2025];

    public function handle()
    {
        $this->info('Mengambil data Non Tender...');

        foreach ($this->years as $year) {
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/74a022b7-0a8a-4e8a-b812-b09ca1646659/json/9617/SPSE-NonTenderPengumuman/tipe/4:4/parameter/{$year}:{$this->lpse}", NonTenderPengumuman::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/51d8ca0c-10f7-404e-ac82-8d86587e08fd/json/9618/SPSE-NonTenderSelesai/tipe/4:4/parameter/{$year}:{$this->lpse}", NonTenderSelesai::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/07c8ac96-5de5-4116-859d-7826e5d37f24/json/9627/SPSE-PencatatanNonTender/tipe/4:4/parameter/{$year}:{$this->lpse}", PencatatanNonTender::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/447fd5fa-f08d-421f-bbc4-4477a917a790/json/9629/SPSE-PencatatanNonTenderRealisasi/tipe/4:4/parameter/{$year}:{$this->lpse}", RealisasiNonTender::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/7907570a-6182-415c-a779-57e0bf9dd723/json/9611/SPSE-NonTenderEkontrak-SPMKSPP/tipe/4:4/parameter/{$year}:{$this->lpse}", NonTenderSpmk::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/f4cf80ec-5515-406c-9723-7f7a50fce60c/json/9635/SPSE-JadwalTahapanNonTender/tipe/4:4/parameter/{$year}:{$this->lpse}", NonTenderSchedule::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/1e794c40-0463-408c-b780-6d0af864dadc/json/9601/SPSE-NonTenderEkontrak-Kontrak/tipe/4:4/parameter/{$year}:{$this->lpse}", NonTenderKontrak::class);
            $this->fetchAndStore("https://isb.lkpp.go.id/isb-2/api/452b1be7-ab09-456b-bb7a-e5e6cbfab7fa/json/9612/SPSE-NonTenderEkontrak-BAPBAST/tipe/4:4/parameter/{$year}:{$this->lpse}",NonTenderBapbast::class);
        }

        $this->info('✔ Semua data Non Tender berhasil diperbarui.');
    }

    protected function fetchAndStore($url, $model)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data as $item) {
                $model::updateOrCreate(
                    $model::uniqueKeys($item),
                    $item
                );
            }
            $this->info("✔ Data disimpan untuk model: {$model}");
        } else {
            $this->error("Gagal mengambil data dari {$url}");
        }
    }
}
