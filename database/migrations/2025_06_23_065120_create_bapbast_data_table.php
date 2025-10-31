<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bapbast_data', function (Blueprint $table) {
            $table->id();

            // Identitas Tender
            $table->string('kd_tender')->nullable();
            $table->string('nama_paket')->nullable();

            // KLPD dan Satker
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->text('alamat_satker')->nullable();

            // Status dan jenis pengadaan
            $table->string('status_kontrak')->nullable();
            $table->string('jenis_pengadaan')->nullable();

            // LPSE
            $table->unsignedBigInteger('kd_lpse')->nullable();

            // Dokumen kontrak
            $table->string('no_sppbj')->nullable();
            $table->string('no_kontrak')->nullable();
            $table->timestamp('tgl_kontrak')->nullable();

            // Nilai kontrak
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();  // jika ada
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();  // jika ada

            // PPK (Pejabat Pembuat Komitmen)
            $table->string('nama_ppk')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('jabatan_ppk')->nullable();
            $table->string('no_sk_ppk')->nullable();
            $table->string('jabatan_penandatangan_sk')->nullable();

            // Penyedia
            $table->string('nama_penyedia')->nullable();
            $table->text('alamat_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_16_penyedia')->nullable();

            // Wakil sah penyedia
            $table->string('wakil_sah_penyedia')->nullable();
            $table->string('jabatan_wakil_penyedia')->nullable();

            // Dokumen BAST/BAP
            $table->string('no_bast')->nullable();
            $table->timestamp('tgl_bast')->nullable();
            $table->string('no_bap')->nullable();
            $table->timestamp('tgl_bap')->nullable();

            // Progres dan pembayaran
            $table->decimal('besar_pembayaran', 20, 2)->nullable();
            $table->integer('progres_pekerjaan')->nullable();
            $table->string('cara_pembayaran_kontrak')->nullable();

            // Status kontrak tambahan
            $table->timestamp('tgl_penetapan_status_kontrak')->nullable();
            $table->text('alasan_penetapan_status_kontrak')->nullable();

            // Addendum
            $table->string('apakah_addendum')->nullable();
            $table->integer('versi_addendum')->nullable();
            $table->text('alasan_addendum')->nullable();

            // Metadata tambahan
            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bapbast_data');
    }
};
