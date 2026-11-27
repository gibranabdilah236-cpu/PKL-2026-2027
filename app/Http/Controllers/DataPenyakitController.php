<?php

namespace App\Http\Controllers;

use App\Models\DataPenyakit;
use App\Models\TtdTangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataPenyakitController extends Controller
{
    private const KOLOM = [
        'ttd1' => ['judul' => 'Orang Pertama', 'isian' => 'Tanggal', 'type' => 'date'],
        'ttd2' => ['judul' => 'Orang Kedua',   'isian' => 'Jam',     'type' => 'time'],
    ];

    private function ambilTtd()
    {
        return TtdTangan::whereIn('nama_pengguna', array_values(TtdTangan::DAFTAR))
            ->latest('id')
            ->get()
            ->unique('nama_pengguna')
            ->keyBy('nama_pengguna');
    }

    public function index()
    {
        $data = DataPenyakit::orderBy('kode_icd', 'asc')->get();
        $tersimpan = $this->ambilTtd();

        $ttdTersimpan = [];
        foreach (TtdTangan::DAFTAR as $kunci => $nama) {
            $row = $tersimpan->get($nama);

            $ttdTersimpan[$kunci] = $row
                ? ['gambar' => $row->ttd, 'waktu' => $row->waktu]
                : null;
        }

        return view('menu-gibran', compact('data', 'ttdTersimpan'));
    }

    public function pdf(Request $request)
    {
        $tersimpan = $this->ambilTtd();
        $kolom = self::KOLOM;

        foreach ($kolom as $kunci => &$k) {
            $row = $tersimpan->get(TtdTangan::DAFTAR[$kunci]);

            $k['gambar'] = $row ? $row->ttd : null;
            $k['nilai']  = '';

            if ($row && $row->waktu) {
                $k['nilai'] = $k['type'] === 'date'
                    ? Carbon::parse($row->waktu)->format('d-m-Y')
                    : $row->waktu;
            }
        }
        unset($k);

        $pathFoto = public_path('assets/images/foto/Gibran.jpg');
        $foto = file_exists($pathFoto)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($pathFoto))
            : null;

        $pdf = app('dompdf.wrapper')
            ->loadView('unduhgibran', [
                'foto'     => $foto,
                'diagnosa' => DataPenyakit::orderBy('kode_icd', 'asc')->get(),
                'kolom'    => $kolom,
                'dicetak'  => Carbon::now('Asia/Jakarta')->format('d-m-Y H:i'),
            ])
            ->setPaper('a4', 'portrait');

        return $request->boolean('unduh')
            ? $pdf->download('menu-gibran.pdf')
            : $pdf->stream('menu-gibran.pdf');
    }
}