<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');
        $query = Bimbingan::with('dosen')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc');
        if ($status !== 'semua') {
            $query->where('status', $status);
        }
        $bimbingans = $query->get();
        return view('layouts.mahasiswa.bimbingan', compact('bimbingans', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => ['required', 'exists:dosen,id'], // Validasi ke tabel dosen langsung
            'tanggal'  => ['required', 'date', 'after_or_equal:today'],
            'jam'      => ['required'],
            'topik'    => ['required', 'string', 'max:255'],
            'catatan'  => ['nullable', 'string'],
        ]);

        // Simpan langsung dosen_id bawaan form (yaitu ID dari tabel dosen, angka 1)
        Bimbingan::create([
            'user_id'   => Auth::id(),   
            'dosen_id'  => $request->dosen_id, // Gunakan id bawaan form (angka 1)
            'tanggal'   => $request->tanggal,
            'jam'       => $request->jam,
            'topik'     => $request->topik,   
            'catatan'   => $request->catatan, 
            'status'    => 'pending',
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Request bimbingan berhasil dikirim!');
    
    }
       


    public function destroy(Bimbingan $bimbingan)
    {
        if ($bimbingan->user_id !== Auth::id()) abort(403);
        if ($bimbingan->status !== 'pending') {
            return back()->with('error', 'Hanya request pending yang bisa dibatalkan.');
        }
        $bimbingan->delete();
        return back()->with('success', 'Request bimbingan berhasil dibatalkan.');
    }
}