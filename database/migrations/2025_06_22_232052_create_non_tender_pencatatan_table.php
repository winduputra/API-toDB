<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderPencatatanTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_pencatatan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->bigInteger('kd_lpse')->nullable();
            $table->bigInteger('kd_nontender_pct')->unique();
            $table->bigInteger('kd_pkt_dce')->nullable();
            $table->bigInteger('kd_rup')->nullable();
            $table->text('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('total_realisasi', 20, 2)->nullable();
            $table->decimal('nilai_pdn_pct', 20, 2)->nullable();
            $table->decimal('nilai_umk_pct', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->longText('uraian_pekerjaan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_pencatatan');
    }
}
