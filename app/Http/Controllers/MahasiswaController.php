<?php

namespace App\Http\Controllers;

use App\Models\Dosen;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $dosens = Dosen::with('ruangan')->get();
        return view('layouts.mahasiswa.dashboard', compact('dosens'));
    }
}