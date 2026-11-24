<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TandaTanganController extends Controller
{
    // Jenis kolom yang diizinkan => format isian waktunya
    private const FORMAT_WAKTU = [
        'pertama' => 'Y-m-d', // tanggal
        'kedua'   => 'H:i',   // jam
    ];

    public function store(Request $request)
    {
        $jenisValid = implode(',', array_keys(self::FORMAT_WAKTU));

        $request->validate([
            'nama'         => 'required|string|max:100',
            'nis'          => 'required|string|max:50',
            'jenis'        => 'required|in:' . $jenisValid,
            'tanda_tangan' => 'required|string',
        ]);

        // Validasi isian tanggal/jam sesuai jenisnya (boleh kosong)
        $request->validate([
            'waktu' => 'nullable|date_format:' . self::FORMAT_WAKTU[$request->jenis],
        ], [
            'waktu.date_format' => 'Format tanggal/jam tidak valid',
        ]);

        if (!Str::startsWith($request->tanda_tangan, 'data:image/png;base64,')) {
            return response()->json(['message' => 'Format tidak valid'], 422);
        }

        $gambar = base64_decode(Str::after($request->tanda_tangan, 'base64,'), true);

        // Harus benar-benar PNG (cek signature file) dan maksimal 500 KB
        if ($gambar === false
            || substr($gambar, 0, 8) !== "\x89PNG\r\n\x1a\n"
            || strlen($gambar) > 500 * 1024) {
            return response()->json(['message' => 'Gambar tidak valid atau terlalu besar'], 422);
        }

        $path = 'tanda-tangan/' . Str::uuid() . '.png';
        Storage::disk('public')->put($path, $gambar);

        // Satu NIS + satu jenis = satu tanda tangan. Kalau sudah ada, ganti dan hapus file lamanya.
        $lama = TandaTangan::where('nis', $request->nis)
            ->where('jenis', $request->jenis)
            ->first();

        $data = [
            'nama'  => $request->nama,
            'waktu' => $request->waktu,
            'path'  => $path,
        ];

        if ($lama) {
            Storage::disk('public')->delete($lama->path);
            $lama->update($data);
        } else {
            TandaTangan::create($data + [
                'nis'   => $request->nis,
                'jenis' => $request->jenis,
            ]);
        }

        return response()->json(['message' => 'Tersimpan']);
    }

    // Menampilkan gambar paraf langsung dari storage (tidak perlu `storage:link`)
    public function gambar($nis, $jenis)
    {
        if (!array_key_exists($jenis, self::FORMAT_WAKTU)) {
            abort(404);
        }

        $ttd  = TandaTangan::where('nis', $nis)->where('jenis', $jenis)->firstOrFail();
        $disk = Storage::disk('public');

        if (!$disk->exists($ttd->path)) {
            abort(404);
        }

        return response()->file($disk->path($ttd->path), [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }

    public function destroy($nis, $jenis)
    {
        if (!array_key_exists($jenis, self::FORMAT_WAKTU)) {
            return response()->json(['message' => 'Jenis tidak valid'], 422);
        }

        $ttd = TandaTangan::where('nis', $nis)->where('jenis', $jenis)->first();

        if (!$ttd) {
            return response()->json(['message' => 'Tanda tangan tidak ditemukan'], 404);
        }

        Storage::disk('public')->delete($ttd->path); // hapus file PNG
        $ttd->delete();                              // hapus baris di database

        return response()->json(['message' => 'Tanda tangan dihapus']);
    }
}
