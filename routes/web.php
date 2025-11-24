<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\GajiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. TAMU (GUEST) - Hanya bisa akses Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// 2. AREA KHUSUS MEMBER (AUTH) - Harus Login Dulu
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Karyawan
    Route::controller(KaryawanController::class)->group(function () {
        Route::get('/karyawan', 'index')->name('karyawan.index');
        Route::post('/karyawan', 'store')->name('karyawan.store');
        Route::put('/karyawan/{id}', 'update')->name('karyawan.update');
        Route::delete('/karyawan/{id}', 'destroy')->name('karyawan.destroy');
    });

    // Modul Gaji
    Route::controller(GajiController::class)->group(function () {
        Route::get('/gaji', 'index')->name('gaji.index');
        Route::post('/gaji', 'store')->name('gaji.store');
        Route::put('/gaji/{id}', 'update')->name('gaji.update');
        Route::delete('/gaji/{id}', 'destroy')->name('gaji.destroy');
    });
});