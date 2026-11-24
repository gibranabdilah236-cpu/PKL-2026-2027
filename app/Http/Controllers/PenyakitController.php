<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penyakit = Penyakit::query();

        if ($search) {
            $penyakit->where(function ($query) use ($search) {
                $query->where('kode_icd', 'like', "%{$search}%")
                    ->orWhere('diagnosis_penyakit', 'like', "%{$search}%");
            });
        }

        $penyakit = $penyakit->paginate(10)->withQueryString();

        return view('aliz', compact('penyakit', 'search'));
    }
}
