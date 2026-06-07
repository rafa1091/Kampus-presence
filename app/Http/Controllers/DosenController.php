<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    private function getDosen()
    {
        return Dosen::where('user_id', Auth::id())->first();
    }

    // DASHBOARD
    public function dashboard()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            $dosen = (object)[
                'id'      => null,
                'nama'    => Auth::user()->name,
                'status'  => 'tidak_ada',
                'catatan' => null,
                'no_hp'   => null,
                'foto'    => null,
            ];
            $statistik = ['pending' => 0, 'diterima' => 0, 'total' => 0];
        } else {
            $statistik = [
                'pending'  => Bimbingan::where('dosen_id', $dosen->id)->where('status', 'pending')->count(),
                'diterima' => Bimbingan::where('dosen_id', $dosen->id)->where('status', 'approved')->count(),
                'total'    => Bimbingan::where('dosen_id', $dosen->id)->count(),
            ];
        }

        return view('layouts.dosen.dashboard', compact('dosen', 'statistik'));
    }

    // UPDATE STATUS
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status'  => 'required|in:di_ruangan,mengajar,bimbingan,tidak_ada',
            'catatan' => 'nullable|string|max:500',
        ]);

        $dosen = $this->getDosen();
        if (!$dosen) abort(403);

        $dosen->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('dosen.dashboard')->with('success', 'Status berhasil diperbarui.');
    }

    // UPDATE PROFIL
    public function updateProfil(Request $request)
    {
        $request->validate([
            'no_hp'       => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $dosen = $this->getDosen();
        if (!$dosen) abort(403);

        $data = ['no_hp' => $request->no_hp];

        if ($request->hasFile('foto_profil')) {
            $data['foto'] = $request->file('foto_profil')->store('foto-dosen', 'public');
        }

        $dosen->update($data);

        return redirect()->route('dosen.dashboard')->with('success', 'Profil berhasil disimpan.');
    }

    // BIMBINGAN
    public function bimbingan(Request $request)
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            $requests = collect();
            return view('layouts.dosen.bimbingan', compact('requests'));
        }

        $active = $request->query('filter', 'SEMUA');

        $query = Bimbingan::with('user')
            ->where('dosen_id', $dosen->id)
            ->orderBy('tanggal', 'desc');

        if ($active !== 'SEMUA') {
            $query->where('status', strtolower($active));
        }

        $requests = $query->get()->map(function ($item) {
            return (object)[
                'id'       => $item->id,
                'tanggal'  => $item->tanggal,
                'jam'      => $item->jam,
                'mahasiswa'=> $item->user->name ?? '-',
                'nim'      => $item->user->nim ?? null,
                'topik'    => $item->topik,
                'pesan'    => $item->catatan,
                'balasan'  => $item->catatan_dosen,
                'status'   => strtoupper($item->status),
            ];
        });

        return view('layouts.dosen.bimbingan', compact('requests'));
    }

    // JADWAL
    public function jadwal()
    {
        $dosen = $this->getDosen();

        if (!$dosen) {
            $jadwal = [];
            return view('layouts.dosen.jadwal', compact('jadwal'));
        }

        $jadwal = Jadwal::where('dosen_id', $dosen->id)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('mulai')
            ->get()
            ->map(fn($j) => [
                'id'         => $j->id,
                'hari'       => $j->hari,
                'mulai'      => $j->mulai,
                'selesai'    => $j->selesai,
                'aktifitas'  => $j->aktifitas,
                'matakuliah' => $j->matakuliah,
            ])
            ->toArray();

        return view('layouts.dosen.jadwal', compact('jadwal'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'mulai'      => 'required',
            'selesai'    => 'required',
            'aktifitas'  => 'required|string',
            'matakuliah' => 'nullable|string|max:100',
        ]);

        $dosen = $this->getDosen();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        Jadwal::create([
            'dosen_id'   => $dosen->id,
            'hari'       => $request->hari,
            'mulai'      => $request->mulai,
            'selesai'    => $request->selesai,
            'aktifitas'  => $request->aktifitas,
            'matakuliah' => $request->matakuliah,
        ]);

        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function destroyJadwal($id)
    {
        $dosen  = $this->getDosen();
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->dosen_id !== $dosen->id) abort(403);

        $jadwal->delete();

        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}