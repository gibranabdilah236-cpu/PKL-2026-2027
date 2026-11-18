<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/menu-aby', [DashboardController::class, 'index'])->name('menu.aby');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
<<<<<<< HEAD
});

Route::get('/aliz', function () {
    return view('aliz');
=======
>>>>>>> 913444ef15cbbcd45a01ab8e905d649c24340230
});