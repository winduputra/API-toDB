<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('satkers', function (Blueprint $table) {
            $table->string('kd_satker_lpse')->nullable()->after('kd_satker');
        });
    }

    public function down(): void {
        Schema::table('satkers', function (Blueprint $table) {
            $table->dropColumn('kd_satker_lpse');
        });
    }
};
