<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $penyakit = Penyakit::where('kode_icd', 'like', "%$search%")
            ->orWhere('diagnosis_penyakit', 'like', "%$search%")
            ->paginate(10);

        return view('penyakit.index', compact('penyakit', 'search'));
    }
}
