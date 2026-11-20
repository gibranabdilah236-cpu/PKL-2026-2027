@extends('layouts.dashboard.master')

@section('title', 'Menu Gibran')

@section('breadcrumb-title')
<h3>Gibran D. Abdilah</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="">Gibran</a></li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div style="background: #46698b; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; max-width: 320px; text-align: left; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <center>
                        <img src="{{ asset('assets/images/foto/Gibran.jpg') }}" alt="Foto Gibran" style="width: 130px; height: 160px; border-radius: 8px; object-fit: cover; margin-bottom: 16px; border: 1px solid #e5e7eb;">
                        <h4 style="font-size: 16px; font-weight: bold; color: #000000; margin-bottom: 4px;">Gibran Dwiki Abdilah</h4>
                        <p style="font-size: 14px; color: #000000; margin-bottom: 12px;">NIS: 3271300097</p>
                        <hr style="border: none; border-top: 1px solid #000000; margin: 12px 0;">
                        <p style="font-size: 13px; color: #000000; margin: 0;">Praktik Kerja Lapangan (PKL)<br>RSUD Kota Bogor</p>
                    </center>
                </div>

                <div class="table-responsive mt-4">
                    <style>
                        .table-custom th {
                            background-color: #34495e;
                            color: white;
                            padding: 12px;
                            text-align: left;
                            border: 1px solid #000000;
                        }
                        .table-custom td {
                            padding: 10px 12px;
                            border: 1px solid #000000;
                            color: #000000;
                        }
                    </style>

                    <table id="tabelPenyakit" class="table-custom" style="width:100%">
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
                                <td>{{ $row->diagnosis_penyakit }}</td>
                                <td>{{ $row->jumlah_kasus }}</td>
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

@push('after-style')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatable/datatables.min.css') }}">
@endpush

@push('after-script')
<script src="{{ asset('assets/vendors/datatable/datatables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#tabelPenyakit').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
            }
        });
    });
</script>
@endpush