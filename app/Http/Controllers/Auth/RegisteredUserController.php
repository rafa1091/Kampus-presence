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
<<<<<<< HEAD
        'email'     => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
=======
        'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
        'password'  => ['required', Rules\Password::defaults()],
        'role'      => ['required', 'string'],
        'id_number' => ['required', 'string'],
    ]);

<<<<<<< HEAD
    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'nip'      => $request->id_number, // ✅ ubah nim → nip
        'no_hp'    => $request->no_hp,
        'role'     => $request->role,
    ]);

    // Tidak auto-login, langsung ke halaman login
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
=======
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
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
}
}