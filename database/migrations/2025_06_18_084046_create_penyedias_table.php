<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyedias', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_anggaran');
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->bigInteger('kd_satker');
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->bigInteger('kd_rup')->unique();
            $table->text('nama_paket')->nullable();
            $table->double('pagu')->nullable();
            $table->integer('kd_metode_pengadaan')->nullable();
            $table->string('metode_pengadaan')->nullable();
            $table->string('kd_jenis_pengadaan')->nullable();
            $table->string('jenis_pengadaan')->nullable();
            $table->string('status_pradipa')->nullable();
            $table->string('status_pdn')->nullable();
            $table->string('status_ukm')->nullable();
            $table->string('alasan_non_ukm')->nullable();
            $table->string('status_konsolidasi')->nullable();
            $table->string('tipe_paket')->nullable();
            $table->string('kd_rup_swakelola')->nullable();
            $table->string('kd_rup_lokal')->nullable();
            $table->string('volume_pekerjaan')->nullable();
            $table->text('urarian_pekerjaan')->nullable();
            $table->text('spesifikasi_pekerjaan')->nullable();
            $table->date('tgl_awal_pemilihan')->nullable();
            $table->date('tgl_akhir_pemilihan')->nullable();
            $table->date('tgl_awal_kontrak')->nullable();
            $table->date('tgl_akhir_kontrak')->nullable();
            $table->date('tgl_awal_pemanfaatan')->nullable();
            $table->date('tgl_akhir_pemanfaatan')->nullable();
            $table->date('tgl_buat_paket')->nullable();
            $table->timestamp('tgl_pengumuman_paket')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('username_ppk')->nullable();
            $table->boolean('status_aktif_rup')->nullable();
            $table->boolean('status_delete_rup')->nullable();
            $table->string('status_umumkan_rup')->nullable();
            $table->boolean('status_dikecualikan')->nullable();
            $table->string('alasan_dikecualikan')->nullable();
            $table->string('tahun_pertama')->nullable();
            $table->string('kode_rup_tahun_pertama')->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->boolean('spp_aspek_ekonomi')->nullable();
            $table->boolean('spp_aspek_sosial')->nullable();
            $table->boolean('spp_aspek_lingkungan')->nullable();
            $table->date('event_date')->nullable()->default(null)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyedias');
    }
};
