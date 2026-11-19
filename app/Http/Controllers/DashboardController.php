<?php

namespace App\Http\Controllers;

use App\Models\DataPenyakit;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'data' => DataPenyakit::orderBy('kode_icd')->get(),
        ]);
    }
}
