<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tender_pengumuman_data', function (Blueprint $table) {
            $table->id();

            $table->string('kd_tender')->nullable();
            $table->string('kd_pkt_dce')->nullable();
            $table->string('kd_rup')->nullable();
            $table->string('nama_paket')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->string('kd_lpse')->nullable();
            $table->string('nama_lpse')->nullable();

            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('kualifikasi_paket')->nullable();
            $table->string('jenis_pengadaan')->nullable();

            $table->string('mtd_pemilihan')->nullable();
            $table->string('mtd_evaluasi')->nullable();
            $table->string('mtd_kualifikasi')->nullable();
            $table->string('kontrak_pembayaran')->nullable();

            $table->string('status_tender')->nullable();
            $table->date('tanggal_status')->nullable();
            $table->integer('versi_tender')->nullable();
            $table->text('ket_ditutup')->nullable();
            $table->text('ket_diulang')->nullable();

            $table->timestamp('tgl_buat_paket')->nullable();
            $table->timestamp('tgl_kolektif_kolegial')->nullable();
            $table->timestamp('tgl_pengumuman_tender')->nullable();

            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->text('nip_pokja')->nullable();
            $table->text('nama_pokja')->nullable();
            $table->text('lokasi_pekerjaan')->nullable();
            $table->text('url_lpse')->nullable();
            $table->date('_event_date')->nullable();

            // Tambahan internal
            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            // Kolom nilai kontrak & pembayaran
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('besar_pembayaran', 20, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_pengumuman_data');
    }
};
