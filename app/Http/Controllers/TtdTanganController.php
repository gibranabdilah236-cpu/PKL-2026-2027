<?php

namespace App\Http\Controllers;

use App\Models\TtdTangan;
use Illuminate\Http\Request;

class TtdTanganController extends Controller
{
    public function index()
    {
        return redirect()->route('menu.gibran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'nullable|string|max:255',
            'ttd'           => 'required|string|starts_with:data:image/png;base64,',
        ]);
        
        $ttd = $request->nama_pengguna
            ? TtdTangan::where('nama_pengguna', $request->nama_pengguna)->latest('id')->first()
            : null;

        if ($ttd) {
            $ttd->update(['ttd' => $request->ttd]);
        } else {
            $ttd = TtdTangan::create([
                'nama_pengguna' => $request->nama_pengguna,
                'ttd'           => $request->ttd,
            ]);
        }

        return response()->json([
            'message' => 'Berhasil disimpan!',
            'id'      => $ttd->id,
        ]);
    }
}
