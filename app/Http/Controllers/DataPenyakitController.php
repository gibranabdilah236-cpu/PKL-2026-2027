<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenyakit;
use App\Models\TtdTangan;

class DataPenyakitController extends Controller
{
    public function index()
{
    $data = DataPenyakit::orderBy('kode_icd', 'asc')->get();
    $semuaDataPenyakitPdf = $data;

    // Paraf yang sudah tersimpan di database (ambil yang terbaru per orang)
    $tersimpan = TtdTangan::whereIn('nama_pengguna', [TtdTangan::NAMA_PERTAMA, TtdTangan::NAMA_KEDUA])
        ->latest('id')->get()->unique('nama_pengguna')->keyBy('nama_pengguna');

    $ttdTersimpan = [
        'ttd1' => optional($tersimpan->get(TtdTangan::NAMA_PERTAMA))->ttd,
        'ttd2' => optional($tersimpan->get(TtdTangan::NAMA_KEDUA))->ttd,
    ];

    return view('menu-gibran', compact('data', 'semuaDataPenyakitPdf', 'ttdTersimpan'));
}
} 