<?php

namespace App\Http\Controllers;

use App\Models\TtdTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TtdTanganController extends Controller
{
    public function index()
    {
        return redirect()->route('menu.gibran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => ['required', Rule::in(array_values(TtdTangan::DAFTAR))],
            'ttd'           => 'required|string|max:700000',
            'waktu'         => 'nullable|string|max:20',
        ]);

        if (!Str::startsWith($request->ttd, 'data:image/png;base64,')) {
            return response()->json(['message' => 'Format tidak valid'], 422);
        }

        $gambar = base64_decode(Str::after($request->ttd, 'base64,'), true);

        if ($gambar === false
            || substr($gambar, 0, 8) !== "\x89PNG\r\n\x1a\n"
            || strlen($gambar) > 500 * 1024) {
            return response()->json(['message' => 'Gambar tidak valid atau terlalu besar'], 422);
        }

        $ttd = TtdTangan::updateOrCreate(
            ['nama_pengguna' => $request->nama_pengguna],
            ['ttd' => $request->ttd, 'waktu' => $request->waktu]
        );

        return response()->json([
            'message' => 'Berhasil disimpan!',
            'id'      => $ttd->id,
        ]);
    }

    public function destroy($kunci)
    {
        if (!array_key_exists($kunci, TtdTangan::DAFTAR)) {
            return response()->json(['message' => 'Jenis tidak valid'], 422);
        }

        $jumlah = TtdTangan::where('nama_pengguna', TtdTangan::DAFTAR[$kunci])->delete();

        if (!$jumlah) {
            return response()->json(['message' => 'Tanda tangan tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Tanda tangan dihapus']);
    }
}