<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/chat', [ChatController::class, 'chat']);

// ── PUBLIC ──
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'dosen'
            ? redirect()->route('dosen.dashboard')
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});

// ── GUEST ONLY ──
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    
    // 1. TAMBAHKAN RUTE KHUSUS HALAMAN PILIH ROLE
    Route::get('/select-role', function() {
        return view('auth.select-role'); // Sesuaikan dengan nama file blade pilih role-mu
    })->name('register.role');

    // 2. Rute register yang aslinya tetap di bawahnya
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ── AUTH REQUIRED ──
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

   // ── DOSEN ──
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard',        [DosenController::class, 'dashboard'])->name('dashboard');
        Route::get('/jadwal',           [DosenController::class, 'jadwal'])->name('jadwal');
        
        // GANTI DI SINI: Sesuaikan namanya dengan yang dipanggil di file Blade
        Route::post('/jadwal',          [DosenController::class, 'storeJadwal'])->name('storeJadwal');
        Route::delete('/jadwal/{id}',   [DosenController::class, 'destroyJadwal'])->name('destroyJadwal');
        
        Route::get('/bimbingan',        [DosenController::class, 'bimbingan'])->name('bimbingan');
        Route::put('/status',           [DosenController::class, 'updateStatus'])->name('status.update');
        Route::put('/profil',           [DosenController::class, 'updateProfil'])->name('profil.update');
        Route::post('/bimbingan/{id}/approve',[DosenController::class, 'approve'])->name('bimbingan.approve');
        Route::post('/bimbingan/{id}/reject',[DosenController::class, 'reject'])->name('bimbingan.reject');
    });

    // ── MAHASISWA ──
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');

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
});

require __DIR__.'/auth.php';