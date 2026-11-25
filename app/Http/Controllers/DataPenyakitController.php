<?php

namespace App\Http\Controllers;

use App\Models\DataPenyakit;
use App\Models\TtdTangan;

class DataPenyakitController extends Controller
{
    public function index()
    {
        $data = DataPenyakit::orderBy('kode_icd', 'asc')->get();
        $semuaDataPenyakitPdf = $data;

        $tersimpan = TtdTangan::whereIn('nama_pengguna', array_values(TtdTangan::DAFTAR))
            ->latest('id')
            ->get()
            ->unique('nama_pengguna')
            ->keyBy('nama_pengguna');

        $ttdTersimpan = [];
        foreach (TtdTangan::DAFTAR as $kunci => $nama) {
            $row = $tersimpan->get($nama);

            $ttdTersimpan[$kunci] = $row
                ? ['gambar' => $row->ttd, 'waktu' => $row->waktu]
                : null;
        }

        return view('menu-gibran', compact('data', 'semuaDataPenyakitPdf', 'ttdTersimpan'));
    }
}
