<?php

namespace App\Http\Controllers;

use App\Models\KasusPenyakit;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'data' => KasusPenyakit::orderBy('kode_icd')->get(),
        ]);
    }
}
