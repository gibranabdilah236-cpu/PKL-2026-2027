<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyakitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penyakit = DB::table('kasus_penyakits');

        if ($search) {
            $penyakit->where(function ($query) use ($search) {
                $query->where('kode_icd', 'like', "%{$search}%")
                    ->orWhere('diagnosis_penyakit', 'like', "%{$search}%");
            });
        }

        $penyakit = $penyakit->orderBy('kode_icd')
            ->paginate(10)
            ->withQueryString();

        return view('aliz', compact('penyakit', 'search'));
    }
}