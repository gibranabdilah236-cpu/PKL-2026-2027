<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasusPenyakitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('kasus_penyakits', function (Blueprint $table) {
        $table->id();
        $table->string('kode_icd', 10)->index();
        $table->string('diagnosis');
        $table->unsignedInteger('jumlah_kunjungan')->default(0);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('kasus_penyakits');
}

}
