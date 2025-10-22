<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateTenderData extends Command
{
    protected $signature = 'update:tender-data';
    protected $description = 'Sinkronisasi data tender dari 7 API LKPP untuk tahun 2024 dan 2025, LPSE 121';

    protected $tahunList = ['2024', '2025'];
    protected $lpse = '121';

    protected $apiList = [
        'TenderPengumuman'      => 'https://isb.lkpp.go.id/isb-2/api/b6af9705-49be-4667-bfb4-0d968e3bd452/json/9616/SPSE-TenderPengumuman/tipe/4:4/parameter/{tahun}:{lpse}',
        'TenderSelesai'         => 'https://isb.lkpp.go.id/isb-2/api/af74e3c5-dec0-476a-835b-707a2ba6d888/json/9641/SPSE-TenderSelesai/tipe/4:4/parameter/{tahun}:{lpse}',
        'TenderSelesaiNilai'    => 'https://isb.lkpp.go.id/isb-2/api/5142094e-d93d-4592-8706-bcd67f284c3e/json/9640/SPSE-TenderSelesaiNilai/tipe/4:4/parameter/{tahun}:{lpse}',
        'SPPBJ'                 => 'https://isb.lkpp.go.id/isb-2/api/ebefa64c-2f3f-477f-8853-515fac24fcad/json/9620/SPSE-TenderEkontrak-SPPBJ/tipe/4:4/parameter/{tahun}:{lpse}',
        'SPMKSPP'               => 'https://isb.lkpp.go.id/isb-2/api/21e98319-21c8-42a7-9583-3438904a1605/json/9621/SPSE-TenderEkontrak-SPMKSPP/tipe/4:4/parameter/{tahun}:{lpse}',
        'BAPBAST'               => 'https://isb.lkpp.go.id/isb-2/api/fef4aae1-4b46-40d0-8e23-2b8855663273/json/9622/SPSE-TenderEkontrak-BAPBAST/tipe/4:4/parameter/{tahun}:{lpse}',
        'Kontrak'               => 'https://isb.lkpp.go.id/isb-2/api/318a5719-57e1-4426-ba04-906d409cfe40/json/9623/SPSE-TenderEkontrak-Kontrak/tipe/4:4/parameter/{tahun}:{lpse}',
    ];

    protected $modelMap = [
        'TenderPengumuman'    => \App\Models\TenderPengumumanData::class,
        'TenderSelesai'       => \App\Models\TenderSelesaiData::class,
        'TenderSelesaiNilai'  => \App\Models\TenderSelesaiNilaiData::class,
        'SPPBJ'               => \App\Models\SppbjData::class,
        'SPMKSPP'             => \App\Models\SpmkSppData::class,
        'BAPBAST'             => \App\Models\BapbastData::class,
        'Kontrak'             => \App\Models\KontrakData::class,
    ];

    public function handle()
    {
        $grandTotal = 0;

        foreach ($this->tahunList as $tahun) {
            foreach ($this->apiList as $sumber => $templateUrl) {
                $model = $this->modelMap[$sumber] ?? null;
                if (!$model) {
                    $this->warn("⛔ Model tidak ditemukan untuk $sumber.");
                    continue;
                }

                $this->info("📡 Mulai sync $sumber untuk tahun $tahun...");
                $start = 0;
                $limit = 100;
                $totalSaved = 0;
                $loopCount = 0;
                $maxLoop = 50;
                $prevBatch = [];

                while (true) {
                    $url = str_replace(['{tahun}', '{lpse}'], [$tahun, $this->lpse], $templateUrl);
                    $url .= "?start={$start}&length={$limit}";

                    try {
                        $response = Http::timeout(60)->get($url);
                    } catch (\Exception $e) {
                        $this->error("❌ Gagal request ke $url: " . $e->getMessage());
                        break;
                    }

                    if (!$response->ok()) {
                        $this->error("❌ Gagal ambil data $sumber - Status: " . $response->status());
                        break;
                    }

                    $dataList = $response->json();

                    if (!is_array($dataList) || empty($dataList)) {
                        $this->info("✅ Tidak ada data lagi dari $sumber ($tahun). Total: $totalSaved");
                        break;
                    }

                    if ($dataList === $prevBatch) {
                        $this->warn("🚫 Batch sama dengan sebelumnya, hentikan loop.");
                        break;
                    }
                    $prevBatch = $dataList;

                    $saved = 0;

                    foreach ($dataList as $item) {
                        $kdTender = $item['kd_tender'] ?? null;
                        if (!$kdTender) continue;

                        // Abaikan jika status tender batal/gagal (kecuali TenderSelesaiNilai)
                        $status = strtolower($item['status_tender'] ?? '');
                        if ($sumber !== 'TenderSelesaiNilai' && (str_contains($status, 'batal') || str_contains($status, 'gagal'))) {
                            continue;
                        }

                        $item['tahun'] = $item['tahun_anggaran'] ?? $tahun;
                        $item['sumber_api'] = $sumber;

                        $data = collect($item)->only((new $model)->getFillable())->toArray();

                        try {
                            $model::updateOrCreate(['kd_tender' => $kdTender], $data);
                            $saved++;
                            $totalSaved++;
                        } catch (\Exception $e) {
                            Log::error("❗ Gagal simpan ke model $sumber: " . $e->getMessage(), $data);
                        }

                       
                    }

                    $this->info("✔️ Batch offset $start: $saved data disimpan.");

                    if (++$loopCount >= $maxLoop) {
                        $this->warn("⚠️ Dibatasi hanya $maxLoop batch. Loop dihentikan.");
                        break;
                    }

                    if ($saved < $limit) {
                        $this->info("✅ Data kurang dari limit. Loop selesai.");
                        break;
                    }

                    $start += $limit;
                }

                $this->info("📥 Total $totalSaved data dari $sumber ($tahun).");
                $grandTotal += $totalSaved;
            }
        }

        $this->info("🎉 Sinkronisasi selesai. Total seluruh data: $grandTotal");
        return 0;
    }
}
