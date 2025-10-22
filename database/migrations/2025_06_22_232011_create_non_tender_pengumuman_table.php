<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTenderPengumumanTable extends Migration
{
    public function up()
    {
        Schema::create('non_tender_pengumuman', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();
            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->text('nama_satker')->nullable();
            $table->bigInteger('lls_id')->nullable();
            $table->integer('kd_lpse')->nullable();
            $table->text('nama_lpse')->nullable();
            $table->bigInteger('kd_nontender')->unique();
            $table->bigInteger('kd_pkt_dce')->nullable();
            $table->string('kd_rup')->nullable();
            $table->text('nama_paket')->nullable();
            $table->decimal('pagu', 20, 2)->nullable();
            $table->decimal('hps', 20, 2)->nullable();
            $table->string('sumber_dana')->nullable();
            $table->text('mak')->nullable();
            $table->string('kualifikasi_paket')->nullable();
            $table->string('jenis_pengadaan')->nullable();
            $table->string('mtd_pemilihan')->nullable();
            $table->string('kontrak_pembayaran')->nullable();
            $table->string('status_nontender')->nullable();
            $table->integer('versi_nontender')->nullable();
            $table->text('ket_diulang')->nullable();
            $table->text('ket_ditutup')->nullable();
            $table->timestamp('tgl_buat_paket')->nullable();
            $table->timestamp('tgl_kolektif_kolegial')->nullable();
            $table->timestamp('tgl_pengumuman_nontender')->nullable();
            $table->text('nip_nama_ppk')->nullable();
            $table->text('nip_nama_pokja')->nullable();
            $table->text('nip_nama_pp')->nullable();
            $table->text('url_lpse')->nullable();
            $table->string('repeat_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('non_tender_pengumuman');
    }
}
