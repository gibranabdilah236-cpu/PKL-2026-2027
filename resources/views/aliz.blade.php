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
    <div class="row">
        <div class="col-md-6">
            <div class="card" data-aos="fade-up">
                <div class="card-body">
                    <img src="{{ asset('assets/image/aliz.jpg') }}"
                         alt="Foto Aliz"
                         class="img-fluid rounded"
                         style="max-width: 250px;">
                </div>

                <div class="card-header">
                    <h4>Aliziyya Kautsara - NIS 242510287</h4>
                </div>

                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection