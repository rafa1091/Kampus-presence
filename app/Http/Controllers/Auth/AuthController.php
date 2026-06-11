<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        // 1. Validasi input form register
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:mahasiswa,dosen', // ⚠️ WAJIB ditambahkan untuk menentukan dashboard
            // 'no_hp' => 'nullable', // Buka komen ini jika kolom no_hp sudah kamu tambahkan di DB lewat migration
        ]);

        // 2. Simpan user baru ke database beserta jabatannya (role)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // 🌟 Mengisi kolom role biar ga kosong di DB
            // 'no_hp' => $request->no_hp, // Buka komen ini jika kolom no_hp sudah aman di DB
        ]);

        // 3. Sistem langsung menganggap user tersebut sudah login
        Auth::login($user);

        // 4. BYPASS LANGSUNG ke dashboard masing-masing tanpa mampir ke '/'
        if ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        }

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}