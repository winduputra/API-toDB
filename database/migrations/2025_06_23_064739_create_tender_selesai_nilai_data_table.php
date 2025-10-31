<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tender_selesai_nilai_data', function (Blueprint $table) {
            $table->id();

            $table->string('kd_tender')->nullable();
            $table->string('kd_paket')->nullable();
            $table->string('kd_rup_paket')->nullable();
            $table->string('nama_paket')->nullable();

            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('nama_satker')->nullable();

            $table->unsignedBigInteger('kd_lpse')->nullable();

            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->decimal('nilai_penawaran', 20, 2)->nullable();
            $table->decimal('nilai_terkoreksi', 20, 2)->nullable();
            $table->decimal('nilai_negosiasi', 20, 2)->nullable();
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();

            $table->string('kd_penyedia')->nullable();
            $table->string('nama_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_16_penyedia')->nullable();

            $table->timestamp('tgl_pengumuman_tender')->nullable();
            $table->timestamp('tgl_penetapan_pemenang')->nullable();

            $table->string('tahun')->nullable(); // tahun_anggaran
            $table->string('sumber_api')->nullable(); // ex: TenderSelesaiNilai

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_selesai_nilai_data');
    }
};
