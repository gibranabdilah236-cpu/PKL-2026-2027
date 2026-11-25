<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtdTangan extends Model
{
    const NAMA_PERTAMA = 'Gibran D. Abdilah (Orang Pertama)';
    const NAMA_KEDUA   = 'Gibran D. Abdilah (Orang Kedua)';

    protected $table = 'ttd_tangans';   
    protected $fillable = ['nama_pengguna', 'ttd'];
}
