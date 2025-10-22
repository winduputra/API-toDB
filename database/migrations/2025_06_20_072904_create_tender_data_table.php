<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderDataTable extends Migration
{
    public function up(): void
{
    Schema::create('pengadaan_data', function (Blueprint $table) {
        $table->id();
        $table->string('kode')->nullable(); // kd_tender atau semacamnya
        $table->string('nama_paket')->nullable();
        $table->string('klpd')->nullable(); // K/L/PD
        $table->string('status_tender')->nullable();
        $table->decimal('pagu', 20, 2)->nullable();
        $table->decimal('hps', 20, 2)->default(0);
        $table->decimal('nilai_pdn_kontrak', 20, 2)->default(0);
        $table->decimal('nilai_umk_kontrak', 20, 2)->default(0);
        $table->decimal('nilai_kontrak', 20, 2)->default(0);
        $table->decimal('besar_pembayaran', 20, 2)->default(0);
        $table->string('tahun')->nullable();
        $table->string('sumber_api')->nullable(); // ini penting        
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('tender_data');
    }
}

