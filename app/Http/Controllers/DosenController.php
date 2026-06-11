<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    private function getDosen()
    {
        return Dosen::where('user_id', Auth::id())->first();
    }

    public function dashboard()
    {
        $dosen = $this->getDosen();
        return view('layouts.dosen.dashboard', compact('dosen'));
    }

    // ── JADWAL / AKTIVITAS ──
    public function jadwal()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $today = now()->toDateString();

        $hariIni = Bimbingan::with('user')
            ->where('dosen_id', $dosen->id)
            ->where('status', 'approved')
            ->where('tanggal', $today)
            ->orderBy('jam')
            ->get();

        $pending = Bimbingan::with('user')
            ->where('dosen_id', $dosen->id)
            ->where('status', 'pending')
            ->orderBy('tanggal')
            ->get();

        $totalApproved = Bimbingan::where('dosen_id', $dosen->id)->where('status', 'approved')->count();
        $totalPending  = Bimbingan::where('dosen_id', $dosen->id)->where('status', 'pending')->count();
        $totalRejected = Bimbingan::where('dosen_id', $dosen->id)->where('status', 'rejected')->count();

        $dosenStatus = $dosen->status;

        return view('layouts.dosen.jadwal', compact(
            'hariIni', 'pending',
            'totalApproved', 'totalPending', 'totalRejected',
            'dosenStatus'
        ));
    }

    // ── BIMBINGAN ──
    public function bimbingan(Request $request)
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $active = strtoupper($request->get('status', 'SEMUA'));

        $requests = Bimbingan::with('user')
            ->where('dosen_id', $dosen->id)
            ->latest()
            ->get();

        return view('layouts.dosen.bimbingan', compact('requests', 'active'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate(['balasan' => 'nullable|string']);

        $dosen = $this->getDosen();

        Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail()
            ->update([
                'status'        => 'approved',
                'catatan_dosen' => $request->balasan,
            ]);

        return redirect()->route('dosen.bimbingan')->with('success', 'Permintaan bimbingan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|string']);

        $dosen = $this->getDosen();

        Bimbingan::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->firstOrFail()
            ->update([
                'status'        => 'rejected',
                'catatan_dosen' => $request->balasan,
            ]);

        return redirect()->route('dosen.bimbingan')->with('success', 'Permintaan bimbingan berhasil ditolak.');
    }

    // ── STATUS & PROFIL ──
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:di_ruangan,mengajar,bimbingan,tidak_ada',
        ]);

        $dosen = $this->getDosen();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $dosen->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $dosen = $this->getDosen();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $dosen->update([
            'name'  => $request->name,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}