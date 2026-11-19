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
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/foto/809240626842351867.jpg') }}"
                                     alt="Foto Aby"
                                     class="img-fluid rounded"
                                     style="max-width: 100px;">
                            </div>
                            <h5>Nama</h5>
                            <p class="mb-0">{{ $nama }}</p>
                            <h5>NIS</h5>
                            <p class="mb-0">{{ $nis }}</p>
                        </div>
                    </div>
                </div>
                     <div class="table-responsive">
                <table id="tabel-icd" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode ICD</th>
                            <th>Diagnosis Penyakit</th>
                            <th>Jumlah Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->kode_icd }}</td>
                            <td>{{ $row->diagnosis }}</td>
                            <td>{{ $row->jumlah_kunjungan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        $('#tabel-icd').DataTable();
    });
</script>
@endpush
