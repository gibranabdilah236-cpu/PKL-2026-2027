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
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ asset('assets/images/foto/809240626842351867.jpg') }}"
                             alt="Foto Aby" class="img-fluid rounded" style="max-width: 100px;">
                        <h5 class="mt-2">Nama</h5>
                        <p class="mb-0">{{ $nama }}</p>
                        <h5>NIS</h5>
                        <p class="mb-0">{{ $nis }}</p>
                    </div>

                    <style>
                        .table-responsive th {
                            background-color: #34495e;
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
                    </style>

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
                                    @forelse($diagnosa as $row)
                                        <tr>
                                            <td>{{ $diagnosa->firstItem() + $loop->index }}</td>
                                            <td>{{ $row->kode_icd }}</td>
                                            <td>{{ $row->diagnosis }}</td>
                                            <td>{{ $row->jumlah_kunjungan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endforelse
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
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection