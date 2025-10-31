<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kontrak_data', function (Blueprint $table) {
            $table->id();

            $table->string('kd_tender')->nullable();
            $table->text('nama_paket')->nullable(); // ⬅ ubah ke text

            $table->string('kd_klpd')->nullable();
            $table->string('nama_klpd')->nullable();
            $table->string('jenis_klpd')->nullable();

            $table->string('kd_satker')->nullable();
            $table->string('kd_satker_str')->nullable();
            $table->text('nama_satker')->nullable(); // ⬅ ubah ke text
            $table->text('alamat_satker')->nullable();
            $table->string('jenis_pengadaan')->nullable();

            $table->unsignedBigInteger('kd_lpse')->nullable();

            $table->text('lingkup_pekerjaan')->nullable();

            $table->string('no_sppbj')->nullable();
            $table->string('no_kontrak')->nullable();

            $table->timestamp('tgl_kontrak')->nullable();
            $table->timestamp('tgl_kontrak_awal')->nullable();
            $table->timestamp('tgl_kontrak_akhir')->nullable();

            $table->string('kota_kontrak')->nullable();

            $table->string('nip_ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->text('jabatan_ppk')->nullable(); // ⬅ ubah ke text
            $table->string('no_sk_ppk')->nullable();

            $table->text('nama_penyedia')->nullable(); // ⬅ aman jadi text
            $table->unsignedBigInteger('kd_penyedia')->nullable();
            $table->string('npwp_penyedia')->nullable();
            $table->string('npwp_16_penyedia')->nullable();
            $table->string('bentuk_usaha_penyedia')->nullable();
            $table->string('tipe_penyedia')->nullable();
            $table->text('anggota_kso')->nullable(); // ⬅ ubah ke text

            $table->string('wakil_sah_penyedia')->nullable();
            $table->text('jabatan_wakil_penyedia')->nullable(); // ⬅ ubah ke text

            $table->string('nama_rek_bank')->nullable();
            $table->string('no_rek_bank')->nullable();
            $table->string('nama_pemilik_rek_bank')->nullable();

            $table->decimal('nilai_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_pdn_kontrak', 20, 2)->nullable();
            $table->decimal('nilai_umk_kontrak', 20, 2)->nullable();

            $table->text('alasan_ubah_nilai_kontrak')->nullable();
            $table->text('alasan_nilai_kontrak_10_persen')->nullable();

            $table->string('jenis_kontrak')->nullable();
            $table->text('informasi_lainnya')->nullable();

            $table->string('status_kontrak')->nullable();
            $table->timestamp('tgl_penetapan_status_kontrak')->nullable();
            $table->text('alasan_penetapan_status_kontrak')->nullable();

            $table->string('apakah_addendum')->nullable();
            $table->integer('versi_addendum')->nullable();
            $table->text('alasan_addendum')->nullable();

            $table->string('tahun')->nullable();
            $table->string('sumber_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrak_data');
    }
};
