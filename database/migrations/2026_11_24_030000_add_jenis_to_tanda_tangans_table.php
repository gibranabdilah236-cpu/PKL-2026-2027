<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisToTandaTangansTable extends Migration
{
    public function up()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            // Data lama otomatis menjadi tanda tangan "pertama"
            $table->string('jenis', 20)->default('pertama')->after('nis');
            $table->index(['nis', 'jenis']);
        });
    }

    public function down()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->dropIndex(['nis', 'jenis']);
            $table->dropColumn('jenis');
        });
    }
}
