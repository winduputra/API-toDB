<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatkerFieldsToAllTenderTables extends Migration
{
    public function up()
    {
        $tables = [
            'tender_pengumuman_data',
            'tender_selesai_data',
            'tender_selesai_nilai_data',
            'sppbj_data',
            'spmk_spp_data',
            'bapbast_data',
            'kontrak_data',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                // Gunakan check agar tidak error kalau kolom sudah ada
                if (!Schema::hasColumn($table->getTable(), 'kd_satker')) {
                    $table->string('kd_satker')->nullable();
                }
                if (!Schema::hasColumn($table->getTable(), 'nama_satker')) {
                    $table->string('nama_satker')->nullable();
                }
            });
        }
    }

    public function down()
    {
        $tables = [
            'tender_pengumuman_data',
            'tender_selesai_data',
            'tender_selesai_nilai_data',
            'sppbj_data',
            'spmk_spp_data',
            'bapbast_data',
            'kontrak_data',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'kd_satker')) {
                    $table->dropColumn('kd_satker');
                }
                if (Schema::hasColumn($table->getTable(), 'nama_satker')) {
                    $table->dropColumn('nama_satker');
                }
            });
        }
    }
}

