@extends('layouts.dashboard.master')

@section('title', 'Menu Aliz')

@section('breadcrumb-title')
<h3>Aliz</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="">Aliz</a></li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-body">
            <img src="{{ asset('assets/image/aliz.jpg') }}"
                 alt="Foto Aliz"
                 width="150"
                 class="rounded mb-3">

            <h4>Aliziyya Kautsara</h4>
            <p>NIS: 242510287</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Data Penyakit Rumah Sakit Umum Daerah Kota Bogor</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('aliz') }}" method="GET">
                <input type="text" name="search"
                       placeholder="Cari penyakit..."
                       value="{{ $search }}">

                <button type="submit">Cari</button>
                <a href="{{ route('aliz') }}">Reset</a>
            </form>

            <br>

            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode ICD</th>
                        <th>Diagnosis Penyakit</th>
                        <th>Jumlah Kunjungan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($penyakit as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($penyakit->currentPage() - 1) * $penyakit->perPage() }}</td>
                        <td>{{ $item->kode_icd }}</td>
                        <td>{{ $item->diagnosis_penyakit }}</td>
                        <td>{{ $item->jumlah_kunjungan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <br>

            {{ $penyakit->links() }}

        </div>
    </div>

</div>
@endsection