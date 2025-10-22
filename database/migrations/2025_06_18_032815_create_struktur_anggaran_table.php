<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('struktur_anggarans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_anggaran');
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('kd_satker');
            $table->string('kd_satker_str')->nullable();
            $table->string('nama_satker')->nullable();
            $table->double('belanja_operasi')->nullable();
            $table->double('belanja_modal')->nullable();
            $table->double('belanja_btt')->nullable();
            $table->double('belanja_non_pengadaan')->nullable();
            $table->double('belanja_pengadaan')->nullable();
            $table->double('total_belanja')->nullable();
            $table->timestamps();

            $table->unique(['tahun_anggaran', 'kd_satker']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_anggarans');
    }
};
