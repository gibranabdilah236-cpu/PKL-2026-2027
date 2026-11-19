<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembersihan extends Model
{
    protected $table = 'pembersihans';

    protected $fillable = ['tanggal', 'ruangan', 'validator'];
}