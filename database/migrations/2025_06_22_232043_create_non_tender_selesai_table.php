<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderSelesaiTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_selesai', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->integer('lpse_id')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->integer('kd_lpse')->nullable();
            $table->string('nama_lpse')->nullable();
            $table->bigInteger('kd_nontender')->unique();
            $table->bigInteger('kd_pkt_dce')->nullable();
            $table->bigInteger('kd_rup')->nullable();
            $table->string('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->decimal('nilai_penawaran', 20, 2)->nullable();
            $table->decimal('nilai_terkoreksi', 20, 2)->nullable();
            $table->decimal('nilai_negosiasi', 20, 2)->nullable();
            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->text('mak')->nullable();
            $table->string('kualifikasi_paket')->nullable();
            $table->string('kontrak_pembayaran')->nullable();
            $table->string('status_nontender')->nullable();
            $table->timestamp('tgl_pengumuman_nontender')->nullable();
            $table->timestamp('tgl_selesai_nontender')->nullable();
            $table->bigInteger('kd_penyedia')->nullable();
            $table->string('nama_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_selesai');
    }
}
