<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sppbj_data', function (Blueprint $table) {
            $table->id();

            $table->string('kd_tender')->nullable();
            $table->string('nama_paket')->nullable();

            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('jenis_pengadaan')->nullable(); // Tambahkan ini

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->text('alamat_satker')->nullable();
            $table->string('status_tender')->nullable();


            $table->unsignedBigInteger('kd_lpse')->nullable();

            $table->string('no_sppbj')->nullable();
            $table->string('lampiran_sppbj')->nullable();
            $table->timestamp('tgl_sppbj')->nullable();
            $table->string('kota_sppbj')->nullable();

            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('jabatan_ppk')->nullable();

            $table->string('nama_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_penyedia_16')->nullable();

            $table->decimal('harga_final', 20, 2)->nullable();
            $table->decimal('nilai_jaminan_pelaksanaan', 20, 2)->nullable();
            $table->integer('masa_berlaku_jaminan')->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();
            $table->string('status_kontrak')->nullable();
            $table->timestamp('tgl_penetapan_status_kontrak')->nullable();
            $table->text('alasan_penetapan_status_kontrak')->nullable();

            $table->string('apakah_addendum')->nullable();
            $table->integer('versi_addendum')->nullable();
            $table->text('alasan_addendum')->nullable();

            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sppbj_data');
    }
};
