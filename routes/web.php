<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\DataPenyakitController;
use App\Http\Controllers\MenuAbyController;
use App\Http\Controllers\TandaTanganController;
use App\Http\Controllers\TtdTanganController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/menu-gibran', [DataPenyakitController::class, 'index'])->name('menu.gibran');
    
    Route::get('/tanda-tangan', [TtdTanganController::class, 'index'])->name('ttd.gibran.index');
    Route::post('/tanda-tangan/simpan', [TtdTanganController::class, 'store'])->name('ttd.gibran.store');
    Route::get('/menu-gibran/pdf', [DataPenyakitController::class, 'pdf'])->name('menu.gibran.pdf');
    Route::delete('/tanda-tangan-gibran/{kunci}', [TtdTanganController::class, 'destroy'])->name('ttd.gibran.destroy');
    
    Route::get('/menu-aby', [MenuAbyController::class, 'index'])->name('menu.aby');
    Route::get('/menu-aby/pdf', [MenuAbyController::class, 'pdf'])->name('menu.aby.pdf');

    Route::post('/ttd-store', [TandaTanganController::class, 'store'])->name('aby.ttd.store');
    Route::get('/tanda-tangan/{nis}/{jenis}/gambar', [TandaTanganController::class, 'gambar'])->name('ttd.gambar');
    Route::delete('/tanda-tangan/{nis}/{jenis}', [TandaTanganController::class, 'destroy'])->name('ttd.destroy');


    Route::get('/aliz', [PenyakitController::class, 'index'])->name('aliz');

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});