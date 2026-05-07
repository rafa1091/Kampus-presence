<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login'); // Pastikan file HTML tadi ditaruh di resources/views/auth/login.blade.php
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

        if ($user->role == 'dosen') {
            return redirect()->route('dosen.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim' => 'required', // Untuk dosen mungkin ini NIDN
            'no_hp' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Tambahkan field lain di migrasi tabel user jika perlu
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}