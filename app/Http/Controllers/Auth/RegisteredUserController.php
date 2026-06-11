<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', Rules\Password::defaults()],
            'role'      => ['required', 'in:mahasiswa,dosen'],
            'id_number' => ['required', 'string'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Kalau dosen, buat record di tabel dosen juga
        if ($request->role === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nama'    => $request->name,
                'nidn'    => $request->id_number,
                'email'   => $request->email,
                'no_hp'   => $request->no_hp,
                'status'  => 'tidak_ada',
            ]);
        }

        Auth::login($user);

        return redirect('/');
    }
}