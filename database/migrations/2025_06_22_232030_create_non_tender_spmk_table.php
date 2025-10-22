<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderSpmkTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_spmk', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable(); 
            $table->string('alamat_satker')->nullable();
            $table->integer('kd_lpse')->nullable();
            $table->bigInteger('kd_nontender')->unique();
            $table->string('nama_paket')->nullable();
            $table->string('mtd_pengadaan')->nullable();
            $table->string('no_sppbj')->nullable();
            $table->string('no_kontrak')->nullable();
            $table->date('tgl_kontrak')->nullable();
            $table->string('no_spmk_spp')->nullable();
            $table->date('tgl_spmk_spp')->nullable();
            $table->dateTime('tgl_mulai_pekerjaan')->nullable();
            $table->dateTime('tgl_selesai_pekerjaan')->nullable();
            $table->string('waktu_penyelesaian')->nullable();
            $table->string('kota_spmk_spp')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('jabatan_ppk')->nullable();
            $table->string('nama_penyedia')->nullable();
            $table->string('alamat_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_16_penyedia')->nullable();
            $table->string('wakil_sah_penyedia')->nullable();
            $table->string('jabatan_wakil_penyedia')->nullable();
            $table->string('status_kontrak')->nullable();
            $table->timestamp('tgl_penetapan_status_kontrak')->nullable();
            $table->string('apakah_addendum')->nullable();
            $table->integer('versi_addendum')->nullable();
            $table->string('alasan_addendum')->nullable();
            $table->text('alasan_penetapan_status_kontrak')->nullable();
            $table->timestamp('_event_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_spmk');
    }
}
