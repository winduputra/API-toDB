<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tender_selesai_data', function (Blueprint $table) {
            $table->id();
            $table->string('kd_tender')->nullable();
            $table->string('nama_paket')->nullable();

            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();

            $table->unsignedBigInteger('kd_lpse')->nullable();
            $table->string('nama_lpse')->nullable();

            $table->string('kd_pkt_dce')->nullable();
            $table->string('kd_rup')->nullable();

            $table->string('status_tender')->nullable();

            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('mak')->nullable();

            $table->string('kualifikasi_paket')->nullable();
            $table->string('jenis_pengadaan')->nullable();

            $table->string('mtd_pemilihan')->nullable();
            $table->string('mtd_evaluasi')->nullable();
            $table->string('mtd_kualifikasi')->nullable();

            $table->string('kontrak_pembayaran')->nullable();

            $table->timestamp('tgl_pengumuman_tender')->nullable();
            $table->timestamp('tgl_penetapan_pemenang')->nullable();

            $table->string('url_lpse')->nullable();

            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_selesai_data');
    }
};
