<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spmk_spp_data', function (Blueprint $table) {
            $table->id();

            $table->string('kd_tender')->nullable();
            $table->string('nama_paket')->nullable();

            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->text('alamat_satker')->nullable();
            $table->string('status_tender')->nullable();
            $table->string('jenis_pengadaan')->nullable(); // Tambahkan ini

            $table->unsignedBigInteger('kd_lpse')->nullable();

            $table->string('no_sppbj')->nullable();
            $table->string('no_kontrak')->nullable();
            $table->string('no_spmk_spp')->nullable();

            $table->timestamp('tgl_spmk_spp')->nullable();
            $table->timestamp('tgl_mulai_pekerjaan')->nullable();
            $table->timestamp('tgl_selesai_pekerjaan')->nullable();

            $table->string('waktu_penyelesaian')->nullable();
            $table->string('kota_spmk_spp')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('jabatan_ppk')->nullable();

            $table->string('nama_penyedia')->nullable();
            $table->text('alamat_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_penyedia_16')->nullable();

            $table->string('wakil_sah_penyedia')->nullable();
            $table->string('jabatan_wakil_penyedia')->nullable();

            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmk_spp_data');
    }
};
