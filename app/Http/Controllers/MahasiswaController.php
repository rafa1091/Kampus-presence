<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
{
    // 1. Ambil semua data dosen beserta data User-nya (untuk Direktori Utama)
    $dosens = Dosen::with('user')->get();

    // 2. Hitung statistik keberadaan dosen untuk Counter Card di atas
    $counter = [
        'di_ruangan' => Dosen::where('status', 'di_ruangan')->count(),
        'mengajar'   => Dosen::where('status', 'mengajar')->count(),
        'bimbingan'  => Dosen::where('status', 'bimbingan')->count(),
        'tidak_ada'  => Dosen::where('status', 'tidak_ada')->count(),
    ];

    // 3. Ambil data user yang sedang login
    $user = auth()->user();
    
    $dosenPembimbing = null;
    // Cek apakah kolom dosen_id ada langsung di tabel users
    if ($user && isset($user->dosen_id)) {
        $dosenPembimbing = Dosen::find($user->dosen_id);
    }

    // Kirim semua variabel ke view
    return view('layouts.mahasiswa.dashboard', compact('dosens', 'counter', 'dosenPembimbing'));
}

}