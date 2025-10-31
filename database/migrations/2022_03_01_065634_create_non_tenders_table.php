<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_tenders', function (Blueprint $table) {
            $table->id();
            $table->string("kd_nontender");
            $table->integer("tahun_anggaran")->nullable();
            $table->string("kd_klpd")->nullable();
            $table->string("nama_klpd")->nullable();
            $table->string("jenis_klpd")->nullable();
            $table->string("kd_satker")->nullable();
            $table->string("nama_satker")->nullable();
            $table->integer("kd_lpse")->nullable();
            $table->string("nama_lpse")->nullable();
            $table->string("kd_rup_paket")->nullable();
            $table->longText("nama_paket")->nullable();
            $table->string("pagu")->nullable();
            $table->string("hps")->nullable();
            $table->bigInteger("nilai_penawaran")->nullable();
            $table->bigInteger("nilai_terkoreksi")->nullable();
            $table->bigInteger("nilai_negosiasi")->nullable();
            $table->bigInteger("nilai_kontrak")->nullable();
            $table->string("anggaran")->nullable();
            $table->string("kualifikasi_paket")->nullable();
            $table->string("kategori_pengadaan")->nullable();
            $table->string("metode_pengadaan")->nullable();
            $table->string("tanggal_buat_paket")->nullable();
            $table->string("tanggal_pengumuman_nontender")->nullable();
            $table->string("tanggal_selesai_nontender")->nullable();
            $table->string("kd_penyedia")->nullable();
            $table->string("nama_penyedia")->nullable();
            $table->string("npwp_penyedia")->nullable();
            $table->string("kode_mak")->nullable();
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
        Schema::dropIfExists('non_tenders');
    }
}
