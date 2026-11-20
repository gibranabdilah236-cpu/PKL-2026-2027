@extends('layouts.dashboard.master')

@section('title', 'Dashboard')

@section('breadcrumb-title')
<h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                
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
