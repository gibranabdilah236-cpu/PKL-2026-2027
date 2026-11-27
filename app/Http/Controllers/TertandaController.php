<?php

namespace App\Http\Controllers;

use App\Models\Tertanda;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TertandaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pertama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'ttd_pertama' => ['required', 'string', 'regex:/^data:image\/png;base64,/'],
            'nama_kedua' => 'required|string|max:255',
            'jam' => 'required',
            'ttd_kedua' => ['required', 'string', 'regex:/^data:image\/png;base64,/'],
        ]);

        $tertanda = Tertanda::create($validated);

        return redirect()
            ->route('aliz')
            ->with('success', 'Data berhasil disimpan.')
            ->with('tertanda_id', $tertanda->id);
    }

    public function cetakPdf(Request $request)
    {
        $validated = $request->validate([
            'nama_pertama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'ttd_pertama' => ['required', 'string', 'regex:/^data:image\/png;base64,/'],
            'nama_kedua' => 'required|string|max:255',
            'jam' => 'required',
            'ttd_kedua' => ['required', 'string', 'regex:/^data:image\/png;base64,/'],
        ]);

        $tertanda = new Tertanda($validated);

        $pdf = Pdf::loadView('pdf.tertanda', compact('tertanda'));

        return $pdf->download('verifikasi-serah-terima.pdf');
    }

    public function pdf(Tertanda $tertanda)
    {
        $pdf = Pdf::loadView('pdf.tertanda', compact('tertanda'));

        return $pdf->download('verifikasi-serah-terima-' . $tertanda->id . '.pdf');
    }
}
