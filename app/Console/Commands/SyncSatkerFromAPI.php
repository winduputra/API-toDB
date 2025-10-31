<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Satker;

class SyncSatkerFromAPI extends Command
{
    protected $signature = 'sync:satker-api';
    protected $description = 'Sync data satker dari API LKPP untuk tahun 2024 dan 2025';

    public function handle()
    {
        $klpd = 'D264';
        $years = [2024, 2025];
        $skipSatker = 350504;

        foreach ($years as $year) {
            $url = "https://isb.lkpp.go.id/isb-2/api/fd33caeb-aee6-42f9-9c60-31bc78a3ca3f/json/9615/RUP-MasterSatker/tipe/12:12/parameter/{$klpd}:{$year}";
            
            $this->info("Fetching satker data for year $year...");
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data as $item) {
                    if ((int)$item['kd_satker'] === $skipSatker) continue;

                    Satker::updateOrCreate(
                        ['kd_satker' => $item['kd_satker']],
                        [
                            'kd_satker_lpse' => $item['kd_satker'], // ✅ Tambahkan ini
                            'kd_satker_str' => $item['kd_satker_str'],
                            'nama_satker'   => $item['nama_satker'],
                            'alamat'        => $item['alamat'],
                            'telepon'       => $item['telepon'],
                            'fax'           => $item['fax'],
                            'kodepos'       => $item['kodepos'],
                            'status_satker' => $item['status_satker'],
                            'ket_satker'    => $item['ket_satker'],
                            'jenis_satker'  => $item['jenis_satker'],
                            'kd_klpd'       => $item['kd_klpd'],
                            'nama_klpd'     => $item['nama_klpd'],
                            'jenis_klpd'    => $item['jenis_klpd'],
                            'kode_eselon'   => $item['kode_eselon'],
                        ]
                    );
                    
                }

                $this->info("Data satker tahun $year berhasil disimpan.");
            } else {
                $this->error("Gagal mengambil data dari API untuk tahun $year");
            }
        }

        return Command::SUCCESS;
    }
}
