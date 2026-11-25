<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenyakit;

class DataPenyakitController extends Controller
{
    public function index()
{
    $data = DataPenyakit::orderBy('kode_icd', 'asc')->get();
    $semuaDataPenyakitPdf = $data;

    return view('menu-gibran', compact('data', 'semuaDataPenyakitPdf'));
}
} 