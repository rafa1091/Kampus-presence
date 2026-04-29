<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Route untuk memproses pendaftaran
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Route Dashboard (Hanya bisa diakses jika sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('layouts.mahasiswa/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store']);
require __DIR__.'/auth.php';