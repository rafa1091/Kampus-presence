<?php

namespace App\Http\Controllers; // Sesuai namespace project kamu, atau App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Dosen; // 🌟 PENTING: Jangan lupa panggil model Dosen di bagian atas!
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        // 1. Validasi input form register
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:mahasiswa,dosen',
            'id_number' => 'required|string', // 🌟 Tambahkan ini jika di form ada input NIDN/NIM
            'no_hp' => 'nullable',
        ]);

        // 2. Simpan user baru ke database beserta jabatannya (role)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
        ]);

        // 🌟 3. TAMBAHKAN LOGIKA INI: Jika pendaftar adalah dosen, buat record di tabel dosen juga
        if ($user->role === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nama'    => $user->name,
                'nidn'    => $request->id_number, // Pastikan name input di blade-mu sesuai
                'email'   => $user->email,
                'status'  => 'tidak_ada', // default status awal
            ]);
        }

        // 4. Sistem langsung menganggap user tersebut sudah login
        Auth::login($user);

        // 5. BYPASS LANGSUNG ke dashboard masing-masing
        if ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        }

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}