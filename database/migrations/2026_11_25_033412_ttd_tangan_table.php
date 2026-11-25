<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TtdTanganTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('ttd_tangans')) {
            return;
        }

        Schema::create('ttd_tangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengguna')->nullable();
            $table->longText('ttd');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ttd_tangans');
    }
}
