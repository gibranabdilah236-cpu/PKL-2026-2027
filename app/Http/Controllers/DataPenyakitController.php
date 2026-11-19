<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenyakit;

class DataPenyakitController extends Controller
{
    public function index()
    {
        $penyakits = DataPenyakit::orderBy('kode_icd', 'asc')->get();

        return view('menu-gibran', [
            'data' => $penyakits,
        ]);
    }
}