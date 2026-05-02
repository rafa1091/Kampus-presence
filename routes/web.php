<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ROUTES ──
Route::get('/', function () {
    return view('welcome');
});

// ── AUTH ROUTES (butuh login) ──
Route::middleware(['auth'])->group(function () {

    // Dashboard Mahasiswa
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])
        ->name('mahasiswa.dashboard');

    // Bimbingan
    Route::resource('/mahasiswa/bimbingan', BimbinganController::class)
        ->names([
            'index'   => 'mahasiswa.bimbingan',
            'create'  => 'mahasiswa.bimbingan.create',
            'store'   => 'mahasiswa.bimbingan.store',
            'show'    => 'mahasiswa.bimbingan.show',
            'edit'    => 'mahasiswa.bimbingan.edit',
            'update'  => 'mahasiswa.bimbingan.update',
            'destroy' => 'mahasiswa.bimbingan.destroy',
        ]);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// ── BREEZE AUTH ROUTES (login, logout, register, dll) ──
require __DIR__.'/auth.php';
// TEMPORARY - hapus setelah logout

// ── BREEZE AUTH ROUTES ──
require __DIR__.'/auth.php';