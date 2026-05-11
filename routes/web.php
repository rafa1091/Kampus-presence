<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ──
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;

        if ($role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    return redirect()->route('login');
});

// ── AUTH (guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── AUTH (LOGIN REQUIRED) ──
Route::middleware(['auth'])->group(function () {

    // DOSEN ROUTES
    Route::prefix('dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
        Route::get('/jadwal', [DosenController::class, 'jadwal'])->name('dosen.jadwal');
        Route::get('/bimbingan', [DosenController::class, 'bimbingan'])->name('dosen.bimbingan');
        Route::put('/status', [DosenController::class, 'updateStatus'])->name('dosen.status.update');
        Route::put('/profil', [DosenController::class, 'updateProfil'])->name('dosen.profil.update');
    });

    // MAHASISWA ROUTES
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

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('dosen')->name('dosen.')->group(function () {

        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::get('/jadwal', [DosenController::class, 'jadwal'])->name('jadwal');
        Route::post('/jadwal', [DosenController::class, 'storeJadwal'])->name('jadwal.store');
        Route::delete('/jadwal/{id}', [DosenController::class, 'destroyJadwal'])->name('jadwal.destroy');
    
        Route::get('/bimbingan', [DosenController::class, 'bimbingan'])->name('bimbingan');
    
        Route::put('/status', [DosenController::class, 'updateStatus'])->name('status.update');
        Route::put('/profil', [DosenController::class, 'updateProfil'])->name('profil.update');
    });
});

require __DIR__.'/auth.php';