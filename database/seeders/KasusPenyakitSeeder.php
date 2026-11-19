<?php

namespace Database\Seeders;

use App\Models\KasusPenyakit;
use Illuminate\Database\Seeder;

class KasusPenyakitSeeder extends Seeder
{
    /**
     * Data contoh (jumlah kunjungan hanya contoh).
     * Data asli bisa di-import lewat Navicat.
     */
    public function run()
    {
        $rows = [
            ['A01.0', 'Typhoid fever', 5],
            ['A02.0', 'Salmonella enteritis', 2],
            ['A02.2', 'Localized salmonella infections', 0],
            ['A06.0', 'Acute amoebic dysentery', 1],
            ['A08.1', 'Acute gastroenteropathy due to norwalk agent', 0],
            ['A09.0', 'Other and unspecified gastroenteritis and colitis of infectious origin', 3],
            ['A09.9', 'Gastroenteritis and colitis of unspecified origin', 12],
            ['A15.0', 'Tb lung confirm sputum microscopy with or without culture', 4],
        ];

        foreach ($rows as [$kode, $diagnosis, $jumlah]) {
            KasusPenyakit::updateOrCreate(
                ['kode_icd' => $kode],
                ['diagnosis' => $diagnosis, 'jumlah_kunjungan' => $jumlah]
            );
        }
    }
}
