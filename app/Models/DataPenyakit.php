<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenyakit extends Model
{
    use HasFactory;

    protected $table = 'data_penyakits';

    protected $fillable = [
        'kode_icd',
        'diagnosis_penyakit',
        'jumlah_kasus',
    ];
}