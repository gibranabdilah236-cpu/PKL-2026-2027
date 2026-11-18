@extends('layouts.dashboard.master')

@section('title', 'Menu Aby')

@section('breadcrumb-title')
<h3>Aby</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="">Aby</a></li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
        <div class="card" data-aos="fade-up">
            <div class="card-body">
                 <img src="{{ asset('assets/images/foto/809240626842351867.jpg') }}"
                  alt="Foto Aby"
                  class="img-fluid rounded"
                  style="max-width: 250px;">
             </div>
            <div class="card-header">
                <h4>Muhamad Aby Ramadhan - NIS 23456787657</h4>
            </div>
            <div class="card-body">

            </div>
        </div>
	</div>
</div>
@endsection