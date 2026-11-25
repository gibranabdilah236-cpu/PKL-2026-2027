<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TtdKeduaTanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('ttd_tangans') && !Schema::hasColumn('ttd_tangans', 'waktu')) {
            Schema::table('ttd_tangans', function (Blueprint $table) {
                $table->string('waktu', 20)->nullable()->after('ttd');
            });
    }
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         if (Schema::hasColumn('ttd_tangans', 'waktu')) {
            Schema::table('ttd_tangans', function (Blueprint $table) {
                $table->dropColumn('waktu');
            });
        }
    }
}