<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('swakelolas', function (Blueprint $table) {
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
            $table->integer('tipe_swakelola')->nullable();
            $table->string('volume_pekerjaan')->nullable();
            $table->text('uraian_pekerjaan')->nullable();
            $table->string('kd_klpd_penyelenggara')->nullable();
            $table->string('nama_klpd_penyelenggara')->nullable();
            $table->string('nama_satker_penyelenggara')->nullable();
            $table->date('tgl_awal_pelaksanaan_kontrak')->nullable();
            $table->date('tgl_akhir_pelaksanaan_kontrak')->nullable();
            $table->date('tgl_buat_paket')->nullable();
            $table->timestamp('tgl_pengumuman_paket')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('username_ppk')->nullable();
            $table->string('kd_rup_lokal')->nullable();
            $table->boolean('status_aktif_rup')->nullable();
            $table->boolean('status_delete_rup')->nullable();
            $table->string('status_umumkan_rup')->nullable();
            $table->date('event_date')->nullable()->default(null)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('swakelolas');
    }
};
