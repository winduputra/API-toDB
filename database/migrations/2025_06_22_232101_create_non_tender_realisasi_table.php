<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderRealisasiTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_realisasi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->bigInteger('kd_lpse')->nullable();
            $table->string('nama_lpse')->nullable();
            $table->bigInteger('kd_nontender_pct')->nullable();
            $table->bigInteger('kd_paket_dce')->nullable();
            $table->string('kd_rup_paket')->nullable();
            $table->text('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->string('jenis_realisasi')->nullable();
            $table->string('no_realisasi')->nullable();
            $table->timestamp('tgl_realisasi')->nullable();
            $table->decimal('nilai_realisasi', 20, 2)->nullable();
            $table->string('dok_realisasi')->nullable();
            $table->text('ket_realisasi')->nullable();
            $table->string('nama_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->timestamp('_event_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_realisasi');
    }
}
