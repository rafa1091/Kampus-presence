<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;

// ── AUTH (guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── PUBLIC ──
Route::get('/', function () {
    return redirect()->intended('/');
});

// ── AUTH (LOGIN REQUIRED) ──
Route::middleware(['auth'])->group(function () {

    // 🔵 DOSEN ROUTES
    Route::prefix('dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])
            ->name('dosen.dashboard');

        Route::get('/jadwal', [DosenController::class, 'jadwal'])
            ->name('dosen.jadwal');

        Route::get('/bimbingan', [DosenController::class, 'bimbingan'])
            ->name('dosen.bimbingan');
    });

    // 🟢 MAHASISWA ROUTES
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('mahasiswa.dashboard');

        Route::resource('/bimbingan', BimbinganController::class)
            ->names([
                'index'   => 'mahasiswa.bimbingan',
                'create'  => 'mahasiswa.bimbingan.create',
                'store'   => 'mahasiswa.bimbingan.store',
                'show'    => 'mahasiswa.bimbingan.show',
                'edit'    => 'mahasiswa.bimbingan.edit',
                'update'  => 'mahasiswa.bimbingan.update',
                'destroy' => 'mahasiswa.bimbingan.destroy',
            ]);
    });

    // 🔐 LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // 👤 PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Breeze auth (biarkan saja)
require __DIR__.'/auth.php';