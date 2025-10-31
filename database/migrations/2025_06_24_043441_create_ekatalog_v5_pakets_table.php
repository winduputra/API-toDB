<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkatalogV5PaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekatalog_v5_pakets', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran');
            $table->string('kd_klpd');
            $table->bigInteger('satker_id');
            $table->text('nama_satker')->nullable();
            $table->text('alamat_satker')->nullable();
            $table->string('npwp_satker')->nullable();
            $table->bigInteger('kd_paket');
            $table->string('no_paket');
            $table->text('nama_paket')->nullable(); 
            $table->bigInteger('kd_rup')->nullable();
            $table->text('nama_sumber_dana')->nullable(); 
            $table->text('kode_anggaran')->nullable();
            $table->bigInteger('kd_komoditas')->nullable();
            $table->bigInteger('kd_produk')->nullable();
            $table->bigInteger('kd_penyedia')->nullable();
            $table->bigInteger('kd_penyedia_distributor')->nullable();
            $table->integer('jml_jenis_produk')->nullable();
            $table->float('kuantitas')->nullable();
            $table->float('harga_satuan')->nullable();
            $table->float('ongkos_kirim')->nullable();
            $table->float('total_harga')->nullable();
            $table->bigInteger('kd_user_pokja')->nullable();
            $table->string('no_telp_user_pokja')->nullable();
            $table->text('email_user_pokja')->nullable(); 
            $table->bigInteger('kd_user_ppk')->nullable();
            $table->string('ppk_nip')->nullable();
            $table->text('jabatan_ppk')->nullable(); 
            $table->date('tanggal_buat_paket')->nullable();
            $table->date('tanggal_edit_paket')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status_paket')->nullable();
            $table->string('paket_status_str')->nullable();
            $table->text('catatan_produk')->nullable(); 
            $table->bigInteger('kd_provinsi_wilayah_harga')->nullable();
            $table->bigInteger('kd_kabupaten_wilayah_harga')->nullable();
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
        Schema::dropIfExists('ekatalog_v5_pakets');
    }
}
