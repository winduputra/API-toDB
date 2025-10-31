<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_schedules', function (Blueprint $table) {
            $table->id();
            $table->string("kd_lelang")->nullable();
            $table->string("kd_tahapan")->nullable();
            $table->string("tahapan")->nullable();
            $table->timestamp("tanggal_awal")->nullable();
            $table->timestamp("tanggal_akhir")->nullable();
            $table->string("kd_akt")->nullable();
            $table->string("nama_akt")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tender_schedules');
    }
}
