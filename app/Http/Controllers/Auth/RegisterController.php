<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:mahasiswa,dosen',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Kalau dosen, buat record di tabel dosen juga
        if ($request->role === 'dosen') {
            \App\Models\Dosen::create([
                'user_id' => $user->id,
                'nidn'    => $request->nidn ?? null,
            ]);
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}