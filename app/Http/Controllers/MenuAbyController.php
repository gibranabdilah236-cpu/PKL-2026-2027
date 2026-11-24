<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuAbyController extends Controller
{
    private $nama = 'Muhamad Aby Ramadhan';
    private $nis  = '123456789';

    public function index()
    {
        return view('menu-aby', [
            'nama'        => $this->nama,
            'nis'         => $this->nis,
            'diagnosa'    => DB::table('kasus_penyakits')->orderBy('kode_icd')->paginate(10),
            'tandaTangan' => TandaTangan::where('nis', $this->nis)->get()->keyBy('jenis'),
        ]);
    }

    public function pdf(Request $request)
    {
        $tersimpan = TandaTangan::where('nis', $this->nis)->get()->keyBy('jenis');

        // Judul & isian harus sama dengan $kolomTtd di menu-aby.blade.php
        $kolom = [
            'pertama' => ['judul' => 'Protokol Diterima Farmasi', 'isian' => 'Tanggal', 'type' => 'date'],
            'kedua'   => ['judul' => 'Diterima Perawat',          'isian' => 'Jam',     'type' => 'time'],
        ];

        foreach ($kolom as $jenis => &$k) {
            $ttd = $tersimpan[$jenis] ?? null;

            $k['nilai']  = '';
            $k['gambar'] = null;

            if ($ttd) {
                if ($ttd->waktu) {
                    $k['nilai'] = $k['type'] === 'date'
                        ? Carbon::parse($ttd->waktu)->format('d-m-Y')
                        : $ttd->waktu;
                }

                // Gambar disisipkan sebagai base64 supaya pasti tampil di PDF
                if (Storage::disk('public')->exists($ttd->path)) {
                    $k['gambar'] = 'data:image/png;base64,'
                        . base64_encode(Storage::disk('public')->get($ttd->path));
                }
            }
        }
        unset($k);

        $pdf = app('dompdf.wrapper')
            ->loadView('menu-aby-pdf', [
                'nama'     => $this->nama,
                'nis'      => $this->nis,
                'diagnosa' => DB::table('kasus_penyakits')->orderBy('kode_icd')->get(),
                'kolom'    => $kolom,
                'dicetak'  => Carbon::now('Asia/Jakarta')->format('d-m-Y H:i'),
            ])
            ->setPaper('a4', 'portrait');

        $namaFile = 'verifikasi-serah-terima-' . $this->nis . '.pdf';

        // ?unduh=1 -> langsung terunduh; tanpa itu -> dibuka di tab baru
        return $request->boolean('unduh')
            ? $pdf->download($namaFile)
            : $pdf->stream($namaFile);
    }
}
