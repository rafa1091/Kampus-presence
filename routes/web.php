<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── PINTU MASUK (Cek Role Saat Akses URL Utama) ──
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'dosen' 
            ? redirect()->route('dosen.dashboard') 
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});

// ── AUTH (Belum Login) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── AUTH (Sudah Login) ──
Route::middleware(['auth'])->group(function () {

    // SEMUA ROUTE DOSEN
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        
        // Route Jadwal
        Route::get('/jadwal', [DosenController::class, 'jadwal'])->name('jadwal');
        Route::post('/jadwal', [DosenController::class, 'storeJadwal'])->name('jadwal.store');
        
        // FIXED: URL dilepas dari '/dosen' dan name dilepas dari 'dosen.' karena sudah dibungkus group prefix & name
        Route::delete('/jadwal/{id}', [DosenController::class, 'deleteJadwal'])->name('jadwal.destroy');
        
        // Route Bimbingan & Aksi Response Dosen
        Route::get('/bimbingan', [DosenController::class, 'bimbingan'])->name('bimbingan');
        Route::put('/bimbingan/{id}/approve', [DosenController::class, 'approveBimbingan'])->name('bimbingan.approve');
        Route::put('/bimbingan/{id}/reject', [DosenController::class, 'rejectBimbingan'])->name('bimbingan.reject');
        
        // Update Status & Profil
        Route::put('/status', [DosenController::class, 'updateStatus'])->name('status.update');
        Route::put('/profil', [DosenController::class, 'updateProfil'])->name('profil.update');
    });

    // SEMUA ROUTE MAHASISWA
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::resource('/bimbingan', BimbinganController::class);

        // Menyelaraskan nama route resource agar ber-prefix mahasiswa.bimbingan
        Route::resource('/bimbingan', BimbinganController::class)->names([
            'index' => 'bimbingan',
            'create' => 'bimbingan.create',
            'store' => 'bimbingan.store',
            'show' => 'bimbingan.show',
            'edit' => 'bimbingan.edit',
            'update' => 'bimbingan.update',
            'destroy' => 'bimbingan.destroy',
        ]);
    
    });

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Jangan hapus baris bawah ini kalau kamu pakai Laravel Breeze
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}