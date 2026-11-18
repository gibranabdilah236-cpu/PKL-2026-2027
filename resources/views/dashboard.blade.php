@extends('layouts.dashboard.master')

@section('title', 'dashboard')

@section('breadcrumb-title')
<h3>Menu Aby</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <div class="card-body">
                                  <img src="{{ asset('assets/images/foto/809240626842351867.jpg') }}"
                                   alt="Foto Aby"
                                   class="img-fluid rounded"
                                   style="max-width: 250px;">
                              </div>
                            <h5>Nama</h5>
                            <p class="mb-0">{{ $nama }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>NIS</h5>
                            <p class="mb-0">{{ $nis }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection