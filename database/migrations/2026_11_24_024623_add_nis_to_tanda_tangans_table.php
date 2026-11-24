<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNisToTandaTangansTable extends Migration
{
    public function up()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->string('nis')->nullable()->index()->after('nama');
        });
    }

    public function down()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->dropIndex(['nis']);
            $table->dropColumn('nis');
        });
    }
}
