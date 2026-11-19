<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenyakitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/menu-gibran', function () {
    return view('menu-gibran');
})->name('menu.gibran');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/menu-aby', [DashboardController::class, 'index'])->name('menu.aby');

    Route::get('/aliz', function () {
        return view('aliz');
    })->name('aliz');

    Route::get('/menu-gibran', function () {
        return view('menu-gibran');
    })->name('menu.gibran');

    Route::get('/penyakit', [PenyakitController::class, 'index'])->name('penyakit.index');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});