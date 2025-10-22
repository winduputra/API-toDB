<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_participants', function (Blueprint $table) {
            $table->id();
            $table->string("kd_tender")->nullable();
            $table->string("kd_lpse")->nullable();
            $table->string("kd_peserta")->nullable();
            $table->string("kd_penyedia")->nullable();
            $table->text("nama_penyedia")->nullable();
            $table->text("npwp_penyedia")->nullable();
            $table->bigInteger("nilai_penawaran")->nullable();
            $table->bigInteger("nilai_terkoreksi")->nullable();
            $table->tinyInteger("pemenang")->nullable();
            $table->tinyInteger("pemenang_terverifikasi")->nullable();
            $table->text("alasan")->nullable();
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
        Schema::dropIfExists('participants');
    }
}
