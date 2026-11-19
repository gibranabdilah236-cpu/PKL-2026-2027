<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasusPenyakit extends Model
{
    use HasFactory;

    protected $table = 'kasus_penyakits';

    protected $fillable = [
        'kode_icd',
        'diagnosis_penyakit',
        'jumlah_kasus',
    ];
}