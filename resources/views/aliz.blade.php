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
</div>
@endsection
