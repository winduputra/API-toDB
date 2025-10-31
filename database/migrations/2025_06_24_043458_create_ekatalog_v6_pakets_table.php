<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkatalogV6PaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('ekatalog_v6_pakets', function (Blueprint $table) {
        $table->id();
        $table->integer('tahun_anggaran');
        $table->string('jenis_instansi')->nullable();
        $table->string('nama_instansi')->nullable();
        $table->string('nama_satker')->nullable();
        $table->string('kd_klpd');
        $table->string('kd_satker_str');
        $table->string('kd_paket');
        $table->bigInteger('kd_rup')->nullable();
        $table->text('rup_nama_pkt')->nullable();
        $table->string('sumber_dana')->nullable();
        $table->text('mak')->nullable();
        $table->bigInteger('kd_penyedia_ppn')->nullable();
        $table->integer('jml_jenis_produk')->nullable();
        $table->integer('jml_produk')->nullable();
        $table->float('ongkir')->nullable();
        $table->float('total_harga')->nullable();
        $table->date('tgl_order')->nullable();
        $table->string('status_pkt')->nullable();
        $table->string('status_pengiriman')->nullable();
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
        Schema::dropIfExists('ekatalog_v6_pakets');
    }
}
