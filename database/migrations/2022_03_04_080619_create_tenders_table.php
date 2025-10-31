<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string("kd_paket")->nullable();
            $table->string("kd_tender");
            $table->string("tahun_anggaran")->nullable();
            $table->string("kd_klpd")->nullable();
            $table->string("nama_klpd")->nullable();
            $table->string("nama_paket")->nullable();
            $table->string("jenis_klpd")->nullable();
            $table->string("kd_satker")->nullable();
            $table->string("kd_lpse")->nullable();
            $table->string("kd_rup_paket")->nullable();
            $table->string("pagu")->nullable();
            $table->string("hps")->nullable();
            $table->string("nilai_penawaran")->nullable();
            $table->string("nilai_terkoreksi")->nullable();
            $table->string("nilai_negosiasi")->nullable();
            $table->string("nilai_kontrak")->nullable();
            $table->string("ang")->nullable();
            $table->string("kualifikasi_paket")->nullable();
            $table->string("kategori_pengadaan")->nullable();
            $table->string("metode_pengadaan")->nullable();
            $table->string("tgl_buat_paket")->nullable();
            $table->string("tgl_pengumuman_tender")->nullable();
            $table->string("tgl_penetapan_pemenang")->nullable();
            $table->string("kd_penyedia")->nullable();
            $table->string("nama_penyedia")->nullable();
            $table->string("npwp_penyedia")->nullable();
            $table->string("mak")->nullable();
            $table->string("nilai_pdn")->nullable();
            $table->string("jenis_pengadaan")->nullable();
            $table->string("mtd_pemilihan")->nullable();
            $table->string("mtd_evaluasi")->nullable();
            $table->string("mtd_kualifikasi")->nullable();
            $table->string("kontrak_pembayaran")->nullable();
            $table->string("kontrak_tahun")->nullable();
            $table->string("jenis_kontrak")->nullable();
            $table->string("nama_status_tender")->nullable();
            $table->string("versi_tender")->nullable();
            $table->text("ket_diulang")->nullable();
            $table->text("ket_ditutup")->nullable();
            $table->string("tgl_kolektif_kolegial")->nullable();
            $table->string("url_lpse")->nullable();
            $table->text("lokasi_pekerjaan")->nullable();
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
        Schema::dropIfExists('tenders');
    }
}
