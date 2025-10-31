<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\StrukturAnggaran;

class StrukturAnggaranUpdate extends Command
{
    protected $signature = 'update:struktur-anggaran';
    protected $description = 'Ambil data Struktur Anggaran dari API SiBAJA untuk tahun 2024 dan 2025 dan simpan ke database';

    public function handle()
    {
        $tahunList = ['2024', '2025'];
        $lpse = 'D264';

        foreach ($tahunList as $tahun) {
            $url = "https://isb.lkpp.go.id/isb-2/api/c0ba31cf-d8ad-406c-89cc-41bb21f9ca3a/json/9632/RUP-StrukturAnggaranPD/tipe/4:12/parameter/{$tahun}:{$lpse}";

            $this->info("Mengambil data Struktur Anggaran tahun $tahun dari:");
            $this->line($url);

            $response = Http::get($url);

            if (!$response->ok()) {
                $this->error("Gagal mengambil data dari API tahun $tahun. Status: " . $response->status());
                continue;
            }

            $data = $response->json();

            if (!is_array($data) || empty($data)) {
                $this->warn("Data kosong atau format tidak sesuai untuk tahun $tahun.");
                continue;
            }

            $this->info("Menyimpan " . count($data) . " data Struktur Anggaran tahun $tahun ke database...");

            foreach ($data as $item) {
                if (
                    ($item['kd_klpd'] ?? '') !== 'D264' ||
                    ($item['nama_klpd'] ?? '') !== 'Provinsi Lampung'
                ) {
                    continue;
                }

                StrukturAnggaran::updateOrCreate(
                    [
                        'tahun_anggaran' => $tahun,
                        'kd_satker' => $item['kd_satker'],
                    ],
                    [
                        'kd_klpd' => $item['kd_klpd'] ?? null,
                        'nama_klpd' => $item['nama_klpd'] ?? null,
                        'kd_satker_str' => $item['kd_satker_str'] ?? null,
                        'nama_satker' => $item['nama_satker'] ?? null,
                        'belanja_operasi' => $item['belanja_operasi'] ?? 0,
                        'belanja_modal' => $item['belanja_modal'] ?? 0,
                        'belanja_btt' => $item['belanja_btt'] ?? 0,
                        'belanja_non_pengadaan' => $item['belanja_non_pengadaan'] ?? 0,
                        'belanja_pengadaan' => $item['belanja_pengadaan'] ?? 0,
                        'total_belanja' => $item['total_belanja'] ?? 0,
                    ]
                );
            }

            $this->info("Selesai menyimpan data Struktur Anggaran tahun $tahun.");
        }

        return 0;
    }
}
