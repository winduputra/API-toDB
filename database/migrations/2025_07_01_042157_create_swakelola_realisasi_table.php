<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwakelolaRealisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // migration file (misal: 2024_07_01_000000_create_swakelola_realisasi_table.php)
Schema::create('swakelola_realisasi', function (Blueprint $table) {
    $table->id();
    $table->string('tahun_anggaran')->nullable();
    $table->string('kd_klpd')->nullable();
    $table->string('kd_satker')->nullable();
    $table->string('nama_satker')->nullable(); // akan dilengkapi nanti dari tabel referensi satker
    $table->bigInteger('kd_swakelola_pct')->nullable();
    $table->string('jenis_realisasi')->nullable();
    $table->string('no_realisasi')->nullable();
    $table->dateTime('tgl_realisasi')->nullable();
    $table->double('nilai_realisasi')->nullable();
    $table->string('dok_realisasi')->nullable();
    $table->text('ket_realisasi')->nullable();
    $table->string('nama_pelaksana')->nullable();
    $table->string('npwp_pelaksana')->nullable();
    $table->string('nip_ppk')->nullable();
    $table->string('nama_ppk')->nullable();
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
        Schema::dropIfExists('swakelola_realisasi');
    }
}
