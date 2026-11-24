<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\DataPenyakitController;
use App\Http\Controllers\MenuAbyController;
use App\Http\Controllers\TandaTanganController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/menu-aby', [MenuAbyController::class, 'index'])->name('menu.aby');
    Route::get('/menu-aby/pdf', [MenuAbyController::class, 'pdf'])->name('menu.aby.pdf');

    // Simpan & hapus tanda tangan (dipakai di halaman Menu Aby)
    Route::post('/tanda-tangan', [TandaTanganController::class, 'store'])->name('ttd.store');
    Route::delete('/tanda-tangan/{nis}/{jenis}', [TandaTanganController::class, 'destroy'])->name('ttd.destroy');

    Route::get('/aliz', [PenyakitController::class, 'index'])->name('aliz');

    Route::get('/menu-gibran', [DataPenyakitController::class, 'index'])->name('menu.gibran');

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
