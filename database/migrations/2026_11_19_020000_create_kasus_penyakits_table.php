<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasus_penyakits', function (Blueprint $table) {
            $table->id();
            $table->string('kode_icd')->unique();
            $table->string('diagnosis_penyakit');
            $table->integer('jumlah_kasus')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasus_penyakits');
    }
};