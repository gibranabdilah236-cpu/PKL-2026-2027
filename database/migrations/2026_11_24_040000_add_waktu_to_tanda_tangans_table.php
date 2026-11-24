<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuToTandaTangansTable extends Migration
{
    public function up()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            // Isi tanggal (pertama) atau jam (kedua), contoh: 2026-11-24 atau 14:30
            $table->string('waktu', 20)->nullable()->after('jenis');
        });
    }

    public function down()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->dropColumn('waktu');
        });
    }
}
