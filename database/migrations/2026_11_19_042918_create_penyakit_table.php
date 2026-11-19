<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyakitTable extends Migration
{
    public function up()
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id();
            $table->string('kode_icd');
            $table->string('diagnosis_penyakit');
            $table->unsignedInteger('jumlah_kunjungan')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyakit');
    }
}
