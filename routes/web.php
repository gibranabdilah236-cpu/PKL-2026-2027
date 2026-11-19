<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  Route::get('/menu-aby', function () {
    return view('menu-aby', [
        'nama' => 'Muhamad Aby Ramadhan',
        'nis'  => '123456789',
        'data' => \App\Models\KasusPenyakit::orderBy('kode_icd')->get(),
    ]);
})->name('menu.aby');

   Route::get('/menu-gibran', function () {
    return view('menu-gibran', [
        'data' => \App\Models\KasusPenyakit::orderBy('kode_icd')->get(),
    ]);
})->name('menu.gibran');

    Route::get('/aliz', function () {
        return view('aliz');
    })->name('aliz');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
