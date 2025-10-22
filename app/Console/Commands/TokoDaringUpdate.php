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

            if (! $response->successful()) {
                $this->error("✖ Gagal ambil data tahun {$tahun}");
                continue;
            }

            $data = $response->json();
            $skipped = 0;
            $inserted = 0;

            foreach ($data as $item) {
                // Skip data yang tidak punya kd_satker
                if (empty($item['kd_satker'])) {
                    $skipped++;
                    $this->warn("⚠️ Lewati order_id {$item['order_id']} karena kd_satker kosong");
                    continue;
                }

                // Hanya ambil field yang relevan
                $payload = [
                    'order_id' => $item['order_id'],
                    'tahun' => $item['tahun'],
                    'kd_klpd' => $item['kd_klpd'],
                    'nama_klpd' => $item['nama_klpd'],
                    'kd_satker' => $item['kd_satker'],
                    'nama_satker' => $item['nama_satker'],
                    'order_desc' => $item['order_desc'],
                    'valuasi' => $item['valuasi'],
                    'kategori' => $item['kategori'],
                    'metode_bayar' => $item['metode_bayar'],
                    'tanggal_transaksi' => $item['tanggal_transaksi'],
                    'marketplace' => $item['marketplace'],
                    'merchant_name' => $item['merchant_name'],
                    'jenis_transaksi' => $item['jenis_transaksi'],
                    'kota_kab' => $item['kota_kab'],
                    'provinsi' => $item['provinsi'],
                    'nama_pemesan' => $item['nama_pemesan'],
                    'status_verif' => $item['status_verif'],
                    'sumber_data' => $item['sumber_data'],
                    'status_konfirmasi_ppmse' => $item['status_konfirmasi_ppmse'],
                    'keterangan_ppmse' => $item['keterangan_ppmse'],
                ];

                try {
                    TokoDaring::updateOrCreate(
                        ['order_id' => $item['order_id']],
                        $payload
                    );
                    $inserted++;
                } catch (\Throwable $e) {
                    $this->error("✖ Gagal simpan order_id {$item['order_id']}: {$e->getMessage()}");
                }
            }

            $this->info("✔ Tahun {$tahun} selesai. {$inserted} data disimpan, {$skipped} data dilewati.");
        }
    }
}
