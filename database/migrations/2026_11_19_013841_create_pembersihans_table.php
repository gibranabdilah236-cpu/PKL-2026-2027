<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembersihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
{
    Schema::create('pembersihans', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('ruangan');
        $table->string('validator');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembersihans');
    }
}
