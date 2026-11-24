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
    
  Route::get('/menu-gibran', function () {
    return view('menu-gibran', [
        'data' => DB::table('data_penyakits')->orderBy('kode_icd')->paginate(10),
    ]);
})->name('menu.gibran');

    Route::get('/menu-aby', function () {
        return view('menu-aby', [
            'nama' => 'Muhamad Aby Ramadhan',
            'nis' => '123456789',
            'diagnosa' => DB::table('kasus_penyakits')->orderBy('kode_icd')->paginate(10),
        ]);
    })->name('menu.aby');

    Route::post('/ttd-store', [TandaTanganController::class, 'store'])->name('ttd.store');

    Route::get('/aliz', [PenyakitController::class, 'index'])->name('aliz');

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});