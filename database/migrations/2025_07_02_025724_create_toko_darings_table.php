<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokoDaringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('toko_darings', function (Blueprint $table) {
        $table->string('order_id')->primary();
        $table->year('tahun');
        $table->string('kd_klpd');
        $table->string('nama_klpd')->nullable();
        $table->string('kd_satker');
        $table->string('nama_satker')->nullable();
        $table->text('order_desc')->nullable();
        $table->double('valuasi')->default(0);
        $table->string('kategori')->nullable();
        $table->string('metode_bayar')->nullable();
        $table->timestamp('tanggal_transaksi')->nullable();
        $table->string('marketplace')->nullable();
        $table->string('merchant_name')->nullable();
        $table->string('jenis_transaksi')->nullable();
        $table->string('kota_kab')->nullable();
        $table->string('provinsi')->nullable();
        $table->string('nama_pemesan')->nullable();
        $table->string('status_verif')->nullable();
        $table->string('sumber_data')->nullable();
        $table->string('status_konfirmasi_ppmse')->nullable();
        $table->string('keterangan_ppmse')->nullable();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko_darings');
    }
}
