<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTertandasTable extends Migration
{
    public function up()
    {
        Schema::create('tertandas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pertama');
            $table->date('tanggal');
            $table->string('ttd_pertama');
            $table->string('nama_kedua');
            $table->time('jam');
            $table->string('ttd_kedua');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tertandas');
    }
}