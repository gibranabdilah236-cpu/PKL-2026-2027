<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TtdTangan extends Model
{
    const NAMA_PERTAMA = 'Gibran D. Abdilah (Orang Pertama)';
    const NAMA_KEDUA   = 'Gibran D. Abdilah (Orang Kedua)';

    const DAFTAR = [
        'ttd1' => self::NAMA_PERTAMA,
        'ttd2' => self::NAMA_KEDUA,
    ];

    protected $table = 'ttd_tangans';
    protected $fillable = ['nama_pengguna', 'ttd', 'waktu'];
}