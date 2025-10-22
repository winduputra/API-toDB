<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Satker;


class SatkerUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'satker:update {--year=2024}';


    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Ambil data Satker dari API untuk tahun 2024 dan 2025 dan simpan ke database';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $years = ['2024', '2025'];
        $klpd = 'D264'; // Kode KLPD Provinsi Lampung

        foreach ($years as $year) {
            $url = "https://isb.lkpp.go.id/isb-2/api/fd33caeb-aee6-42f9-9c60-31bc78a3ca3f/json/9615/RUP-MasterSatker/tipe/12:12/parameter/{$klpd}:{$year}";

            $this->info("Mengambil data Satker untuk tahun {$year} dari API...");
            $this->line($url);

            $response = Http::get($url);

            if (!$response->ok()) {
                $this->error("Gagal mengambil data dari API untuk tahun {$year}. Status: " . $response->status());
                continue;
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                $this->warn("Data kosong atau format tidak sesuai untuk tahun {$year}.");
                continue;
            }

            $this->info("Menyimpan " . count($data) . " data Satker tahun {$year} ke database...");

            foreach ($data as $item) {
                // Validasi dan simpan data Satker dengan tahun_anggaran sesuai dengan tahun yang diambil
                Satker::updateOrCreate(
                    [
                        'kd_satker' => $item['kd_satker'],
                        'tahun_anggaran' => $year,  // Pastikan tahun_anggaran disertakan
                    ],
                    [
                        'kd_satker_str' => $item['kd_satker_str'] ?? null,
                        'nama_satker' => $item['nama_satker'] ?? null,
                        'alamat' => $item['alamat'] ?? null,
                        'telepon' => $item['telepon'] ?? null,
                        'fax' => $item['fax'] ?? null,
                        'kodepos' => $item['kodepos'] ?? null,
                        'status_satker' => $item['status_satker'] ?? null,
                        'ket_satker' => $item['ket_satker'] ?? null,
                        'jenis_satker' => $item['jenis_satker'] ?? null,
                        'kd_klpd' => $item['kd_klpd'] ?? null,
                        'nama_klpd' => $item['nama_klpd'] ?? null,
                        'jenis_klpd' => $item['jenis_klpd'] ?? null,
                        'kode_eselon' => $item['kode_eselon'] ?? null,
                    ]
                );
            }

            $this->info("Selesai menyimpan data Satker tahun {$year}.");
        }

        return 0;

    }
}
