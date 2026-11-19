<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasusPenyakit;

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakits = KasusPenyakit::orderBy('kode_icd', 'asc')->get();

        return view('menu-gibran', [
            'data' => $penyakits
        ]);
    }
}