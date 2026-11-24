<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTtdColumnsToTandaTangansTable extends Migration
{
    public function up()
    {
        // Tiap kolom dicek dulu, jadi aman walau sebagian sudah pernah dibuat
        Schema::table('tanda_tangans', function (Blueprint $table) {
            if (!Schema::hasColumn('tanda_tangans', 'nis')) {
                $table->string('nis')->nullable()->index()->after('nama');
            }
            if (!Schema::hasColumn('tanda_tangans', 'jenis')) {
                // Data lama otomatis menjadi paraf "pertama"
                $table->string('jenis', 20)->default('pertama')->after('nis');
            }
            if (!Schema::hasColumn('tanda_tangans', 'waktu')) {
                // Isi tanggal (pertama) atau jam (kedua)
                $table->string('waktu', 20)->nullable()->after('jenis');
            }
        });
    }

    public function down()
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            foreach (['waktu', 'jenis', 'nis'] as $kolom) {
                if (Schema::hasColumn('tanda_tangans', $kolom)) {
                    $table->dropColumn($kolom);
                }
            }
        });
    }
}
