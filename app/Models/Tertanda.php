<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tertanda extends Model
{
    use HasFactory;

    protected $table = 'tertandas';

    protected $fillable = [
        'nama_pertama',
        'tanggal',
        'ttd_pertama',
        'nama_kedua',
        'jam',
        'ttd_kedua',
    ];
}