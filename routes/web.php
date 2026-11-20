<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\DataPenyakitController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/menu-aby', function () {
        return view('menu-aby', [
            'nama' => 'Muhamad Aby Ramadhan',
            'nis' => '123456789',
            'diagnosa' => DB::table('kasus_penyakits')->paginate(10),
        ]);
    })->name('menu.aby');

    Route::get('/aliz', function () {
        return view('aliz');
    })->name('aliz');

    Route::get('/menu-gibran', [DataPenyakitController::class, 'index'])->name('menu.gibran');

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});