<?php

namespace App\Http\Controllers;

use App\Models\DataPenyakit;

class DashboardController extends Controller
{
    public function index()
    {
        $penyakits = DataPenyakit::orderBy('kode_icd', 'asc')->get();

        return view('dashboard', [
            'data' => $penyakits,
        ]);
    }
}
