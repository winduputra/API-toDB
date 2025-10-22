<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Penyedia;

class PenyediaUpdate extends Command
{
    protected $signature = 'update:penyedia';
    protected $description = 'Ambil data Paket Penyedia dari API SiBAJA untuk tahun 2024 dan 2025 dan simpan ke database';

    public function handle()
    {
        $tahunList = ['2024', '2025'];
        $lpse = 'D264';

        foreach ($tahunList as $tahun) {
            $url = "https://isb.lkpp.go.id/isb-2/api/08df4bbe-8a90-4baa-bf34-330e8a62d2f2/json/9636/RUP-PaketPenyedia-Terumumkan/tipe/4:12/parameter/{$tahun}:{$lpse}";

            $this->info("Mengambil data Penyedia tahun $tahun dari:");
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

            $this->info("Menyimpan " . count($data) . " data Penyedia tahun $tahun ke database...");

            foreach ($data as $item) {
                if (($item['kd_klpd'] ?? '') !== 'D264') {
                    continue;
                }

                Penyedia::updateOrCreate(
                    ['kd_rup' => $item['kd_rup']],
                    [
                        'tahun_anggaran' => $item['tahun_anggaran'],
                        'kd_klpd' => $item['kd_klpd'],
                        'nama_klpd' => $item['nama_klpd'],
                        'kd_satker' => $item['kd_satker'],
                        'nama_satker' => $item['nama_satker'],
                        'nama_paket' => $item['nama_paket'],
                        'pagu' => $item['pagu'],
                        'metode_pengadaan' => $item['metode_pengadaan'] ?? null,
                        'jenis_pengadaan' => $item['jenis_pengadaan'] ?? null,
                        'status_pradipa' => $item['status_pradipa'] ?? null,
                        'status_pdn' => $item['status_pdn'] ?? null,
                        'status_ukm' => $item['status_ukm'] ?? null,
                        'volume_pekerjaan' => $item['volume_pekerjaan'],
                        'urarian_pekerjaan' => $item['urarian_pekerjaan'] ?? null,
                        'spesifikasi_pekerjaan' => $item['spesifikasi_pekerjaan'] ?? null,
                        'tgl_awal_kontrak' => $item['tgl_awal_kontrak'],
                        'tgl_akhir_kontrak' => $item['tgl_akhir_kontrak'],
                        'tgl_pengumuman_paket' => $item['tgl_pengumuman_paket'],
                        'nip_ppk' => $item['nip_ppk'],
                        'nama_ppk' => $item['nama_ppk'],
                        'status_aktif_rup' => $item['status_aktif_rup'],
                        'status_delete_rup' => $item['status_delete_rup'],
                        'status_umumkan_rup' => $item['status_umumkan_rup'],
                    ]
                );
            }

            $this->info("Selesai menyimpan data Penyedia tahun $tahun.");
        }

        return 0;
    }
}
