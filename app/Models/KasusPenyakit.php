<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasusPenyakit extends Model
{
    protected $table = 'kasus_penyakits';

    protected $fillable = ['kode_icd', 'diagnosis', 'jumlah_kunjungan'];
}
