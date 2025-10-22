<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNonTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('non_tenders', function (Blueprint $table) {
            $table->string("nama_status_nontender")->nullable();
            $table->string("versi_nontender")->nullable();
            $table->string("ket_diulang")->nullable();
            $table->string("ket_ditutup")->nullable();
            $table->string("lokasi_pekerjaan")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('non_tenders', function (Blueprint $table) {
            //
        });
    }
}
