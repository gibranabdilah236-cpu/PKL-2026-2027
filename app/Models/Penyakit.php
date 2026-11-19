<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    protected $table = 'penyakit';

    protected $fillable = [
        'kode_icd',
        'diagnosis_penyakit',
        'jumlah_kunjungan',
    ];
}
