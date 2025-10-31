<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\SwakelolaRealisasi;

class UpdateSwakelolaRealisasi extends Command
{
    protected $signature = 'update:swakelola-realisasi';
    protected $description = 'Ambil data Swakelola Realisasi dari API dan simpan ke database';

    public function handle()
    {
        $tahunList = ['2024', '2025'];
        $lpse = '121'; // ✅ disesuaikan ke LPSE 121

        foreach ($tahunList as $tahun) {
            $url = "https://isb.lkpp.go.id/isb-2/api/60c60767-1122-4830-ba33-e7cd6c12095c/json/9626/SPSE-PencatatanSwakelolaRealisasi/tipe/4:4/parameter/{$tahun}:{$lpse}";

            $this->info("🔄 Mengambil data Swakelola Realisasi tahun $tahun dari:");
            $this->line($url);

            try {
                $response = Http::timeout(20)->get($url);
            } catch (\Exception $e) {
                $this->error("❌ Gagal koneksi: " . $e->getMessage());
                continue;
            }

            if (!$response->ok()) {
                $this->error("❌ Gagal ambil data tahun $tahun. Status: " . $response->status());
                continue;
            }

            $data = $response->json();

            if (!is_array($data)) {
                $this->warn("⚠️ Data kosong atau tidak sesuai format.");
                continue;
            }

            $this->info("✅ Memproses " . count($data) . " data tahun $tahun...");

            foreach ($data as $index => $item) {
                try {
                    if (!isset($item['kd_satker']) || !isset($item['no_realisasi'])) {
                        $this->warn("⚠️ Lewati baris $index karena tidak ada kd_satker atau no_realisasi");
                        continue;
                    }

                    SwakelolaRealisasi::updateOrCreate(
                        [
                            'tahun_anggaran' => $item['tahun_anggaran'] ?? $tahun,
                            'kd_satker' => $item['kd_satker'],
                            'no_realisasi' => $item['no_realisasi'] ?? '',
                        ],
                        [
                            'kd_klpd' => $item['kd_klpd'] ?? null,
                            'nama_satker' => $item['nama_satker'] ?? null,
                            'kd_swakelola_pct' => $item['kd_swakelola_pct'] ?? null,
                            'jenis_realisasi' => $item['jenis_realisasi'] ?? null,
                            'tgl_realisasi' => $item['tgl_realisasi'] ?? null,
                            'nilai_realisasi' => is_numeric($item['nilai_realisasi'] ?? null) ? $item['nilai_realisasi'] : 0,
                            'dok_realisasi' => $item['dok_realisasi'] ?? null,
                            'ket_realisasi' => $item['ket_realisasi'] ?? null,
                            'nama_pelaksana' => $item['nama_pelaksana'] ?? null,
                            'npwp_pelaksana' => $item['npwp_pelaksana'] ?? null,
                            'nip_ppk' => $item['nip_ppk'] ?? null,
                            'nama_ppk' => $item['nama_ppk'] ?? null,
                        ]
                    );
                } catch (\Exception $e) {
                    $this->warn("❌ Gagal simpan baris $index: " . $e->getMessage());
                    continue;
                }
            }

            $this->info("✅ Selesai simpan data Swakelola tahun $tahun.");
        }

        return 0;
    }
}
