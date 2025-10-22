<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->integer('kd_lpse')->nullable();
            $table->bigInteger('kd_nontender')->nullable();
            $table->integer('kd_tahapan')->nullable();
            $table->string('nama_tahapan')->nullable();
            $table->integer('kd_akt')->nullable();
            $table->string('nama_akt')->nullable();
            $table->timestamp('tgl_awal')->nullable();
            $table->timestamp('tgl_akhir')->nullable();
            $table->timestamp('_event_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_schedules');
    }
}
