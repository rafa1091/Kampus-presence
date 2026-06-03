<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
public function store(Request $request)
{
    $request->validate([
        'name'      => ['required', 'string', 'max:255'],
        'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password'  => ['required', Rules\Password::defaults()],
        'role'      => ['required', 'string'],
        'id_number' => ['required', 'string'],
    ]);

   // Ganti no_hp menjadi phone sesuai kolom nomor 9 database kamu!
DB::statement("
    INSERT INTO users (name, email, password, nim, phone, role, created_at, updated_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
", [
    $request->name,
    $request->email,
    Hash::make($request->password),
    $request->id_number,
    $request->no_hp ?? '-', // Ambil dari input form, tapi simpan ke kolom 'phone'
    $request->role,
    now(),
    now()
]);

    // 1. Ambil data user yang baru saja masuk ke database berdasarkan email-nya
    $user = User::where('email', $request->email)->first();

    // 2. Perintahkan Laravel untuk otomatis me-login-kan user tersebut
    Auth::login($user);

    // 3. Dilempar ke '/' agar dicek oleh logika role di web.php (Dosen ke dosen, Mhs ke mhs)
    return redirect('/');
}
}