<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <-- 1. Tadi kurang titik koma (;) di sini

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login'); 
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
            'nim' => 'required', 
            'no_hp' => 'required',
            'role' => 'nullable|string', 
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim/nidn' => $request->nim,   
            'no_hp' => $request->no_hp,     
            'role' => $request->role ?? 'mahasiswa', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::find($userId);
        
        Auth::login($user);

        return redirect('/');
    } // <-- 2. Tadi kurung kurawal penutup fungsi register() ini ketinggalan!

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}