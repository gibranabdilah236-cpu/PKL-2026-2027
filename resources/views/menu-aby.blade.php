@extends('layouts.dashboard.master')

@section('title', 'Menu Aby')

@section('breadcrumb-title')
<h3>Menu Aby</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Menu Aby</li>
@endsection

@push('after-style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<style>
    .table-responsive th {
        background-color: #00bfe0;
        color: white;
        padding: 12px;
        text-align: left;
        border: 1px solid #000000;
    }
    .table-responsive td {
        padding: 10px 12px;
        border: 1px solid #000000;
        color: #000000;
    }
    .ttd-card {
        border: 1px solid rgba(128, 128, 128, .4);
        border-radius: 12px;
        padding: 12px 20px 20px;
        margin: 0 0 24px;
        min-width: 0;
    }
    .ttd-card legend {
        float: none;
        width: auto;
        padding: 0 8px;
        margin: 0;
        font-size: 14px;
        font-weight: 600;
    }
    .ttd-card label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
    }
    .ttd-card .waktu-input {
        max-width: 220px;
    }
    .ttd-canvas {
        width: 100%;
        height: 150px;
        border: 2px dashed #999;
        border-radius: 8px;
        background: #fff;
        touch-action: none;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- Kartu identitas --}}
                    <div class="mb-3" style="background: #b2d8ff; border: 1px solid #000000; border-radius: 12px; padding: 24px; max-width: 320px; text-align: left; box-shadow: 0 4px 6px -1px rgba(165, 142, 142, 0.05);">
                        <center>
                            <img src="{{ asset('assets/images/foto/809240626842351867.jpg') }}"
                                 alt="Foto Aby" class="img-fluid rounded" style="max-width: 100px;">
                        </center>
                        <h5 class="mt-2">Nama</h5>
                        <p class="mb-0">{{ $nama }}</p>
                        <h5>NIS</h5>
                        <p class="mb-0">{{ $nis }}</p>
                    </div>

                    {{-- Tabel diagnosa --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode ICD</th>
                                    <th>Diagnosis Penyakit</th>
                                    <th>Jumlah Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($diagnosa as $i => $row)
                                    <tr>
                                        <td>{{ $diagnosa->firstItem() + $i }}</td>
                                        <td>{{ $row->kode_icd }}</td>
                                        <td>{{ $row->diagnosis }}</td>
                                        <td>{{ $row->jumlah_kunjungan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Menampilkan {{ $diagnosa->firstItem() }} - {{ $diagnosa->lastItem() }}
                                dari {{ $diagnosa->total() }} data
                            </small>
                            <div>{{ $diagnosa->links() }}</div>
                        </div>
                    </div>

                    {{-- Verifikasi & Serah Terima --}}
                    <hr>
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h5 class="mb-0">Verifikasi &amp; Serah Terima</h5>
                        <div>
                            <a href="{{ route('menu.aby.pdf') }}" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                            <a href="{{ route('menu.aby.pdf', ['unduh' => 1]) }}" class="btn btn-outline-success btn-sm">Unduh PDF</a>
                        </div>
                    </div>

                    @php
                        // Ubah judul / nama isian di sini. type: date = tanggal, time = jam
                        $kolomTtd = [
                            'pertama' => ['judul' => 'Protokol Diterima Farmasi', 'isian' => 'Tanggal', 'type' => 'date'],
                            'kedua'   => ['judul' => 'Diterima Perawat',          'isian' => 'Jam',     'type' => 'time'],
                        ];
                    @endphp

                    <div class="row">
                        @foreach($kolomTtd as $jenis => $kolom)
                            @php $ttd = $tandaTangan[$jenis] ?? null; @endphp
                            <div class="col-md-6">
                                <fieldset class="ttd-card">
                                    <legend>{{ $kolom['judul'] }}</legend>

                                    <div class="mb-3">
                                        <label for="waktu-{{ $jenis }}">{{ $kolom['isian'] }}</label>
                                        <input type="{{ $kolom['type'] }}" id="waktu-{{ $jenis }}"
                                               class="form-control waktu-input" data-jenis="{{ $jenis }}"
                                               value="{{ $ttd->waktu ?? '' }}">
                                    </div>

                                    <label>Paraf</label>
                                    <canvas class="ttd-canvas" data-jenis="{{ $jenis }}"></canvas>

                                    <div class="mt-2">
                                        <button type="button" class="btn btn-secondary btn-sm btn-bersihkan" data-jenis="{{ $jenis }}">Hapus</button>
                                        <button type="button" class="btn btn-primary btn-sm btn-simpan" data-jenis="{{ $jenis }}">
                                            {{ $ttd ? 'Ganti' : 'Simpan' }}
                                        </button>
                                        @if($ttd)
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-jenis="{{ $jenis }}">Hapus Tersimpan</button>
                                        @endif
                                    </div>

                                    @if($ttd)
                                        <div class="mt-3">
                                            <small class="text-muted">Paraf tersimpan:</small><br>
                                            <img src="{{ route('ttd.gambar', [$nis, $jenis]) }}?v={{ optional($ttd->updated_at)->timestamp }}"
                                                 alt="Paraf {{ $kolom['judul'] }}"
                                                 style="max-width: 200px; border: 1px solid #000; border-radius: 8px; background: #fff;">
                                        </div>
                                    @endif
                                </fieldset>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const NAMA = @json($nama);
    const NIS  = @json($nis);
    const pads = {};

    // Satu SignaturePad untuk tiap kanvas
    document.querySelectorAll('.ttd-canvas').forEach(canvas => {
        const jenis = canvas.dataset.jenis;
        pads[jenis] = new SignaturePad(canvas, { penColor: '#000000' });

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            pads[jenis].clear();
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
    });

    document.querySelectorAll('.btn-bersihkan').forEach(btn => {
        btn.onclick = () => pads[btn.dataset.jenis].clear();
    });

    document.querySelectorAll('.btn-simpan').forEach(btn => {
        btn.onclick = async () => {
            const jenis = btn.dataset.jenis;
            if (pads[jenis].isEmpty()) return alert('Paraf masih kosong');

            try {
                const res = await fetch("{{ route('aby.ttd.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        nama: NAMA,
                        nis: NIS,
                        jenis: jenis,
                        waktu: document.getElementById('waktu-' + jenis).value || null,
                        tanda_tangan: pads[jenis].toDataURL('image/png')
                    })
                });

                const hasil = await res.json();
                alert(hasil.message || 'Terjadi kesalahan');
                if (res.ok) location.reload();
            } catch (e) {
                alert('Gagal menyimpan, coba lagi.');
            }
        };
    });

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.onclick = async () => {
            if (!confirm('Hapus paraf yang tersimpan?')) return;

            const url = "{{ url('/tanda-tangan') }}/" + encodeURIComponent(NIS) + "/" + btn.dataset.jenis;

            try {
                const res = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    }
                });

                const hasil = await res.json();
                alert(hasil.message || 'Terjadi kesalahan');
                if (res.ok) location.reload();
            } catch (e) {
                alert('Gagal menghapus, coba lagi.');
            }
        };
    });
</script>
@endpush
