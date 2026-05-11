<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosen = (object)[
            'nama'           => 'Dosen',
            'status'         => 'sedang_mengajar',
            'status_label'   => 'Sedang Mengajar',
            'catatan_status' => null,
            'ruangan'        => 'Ruang 701',
            'no_hp'          => '0897865645',
            'foto_profil'    => null,
        ];

        $statistik = [
            'pending'  => 0,
            'diterima' => 1,
            'total'    => 1,
        ];

        return view('layouts.dosen.dashboard', compact('dosen', 'statistik'));
    }

    public function jadwal()
    {
        $jadwal = [
            ['hari' => 'senin',  'mulai' => '08:00', 'selesai' => '10:00', 'aktivitas' => 'Mengajar'],
            ['hari' => 'selasa', 'mulai' => '08:00', 'selesai' => '10:00', 'aktivitas' => 'Bimbingan'],
        ];

        return view('layouts.dosen.jadwal-create', compact('jadwal'));
    }

    public function bimbingan()
    {
        $jadwal = [
            ['hari' => 'senin',  'mulai' => '08:00', 'selesai' => '10:00', 'aktivitas' => 'Mengajar'],
            ['hari' => 'rabu',   'mulai' => '13:00', 'selesai' => '15:00', 'aktivitas' => 'Bimbingan'],
        ];

        $requests = [
            (object)[
                'tanggal'  => '2026-03-15',
                'jam'      => '12:30',
                'mahasiswa'=> 'Leon Scott Kennedy',
                'nim'      => '3312401987',
                'topik'    => 'PBL',
                'pesan'    => 'testing',
                'balasan'  => 'oke saya terima',
                'status'   => 'APPROVED',
            ]
        ];

        return view('layouts.dosen.bimbingan', compact('requests', 'jadwal'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status'  => 'required|in:di_ruangan,sedang_mengajar,sedang_bimbingan,tidak_ada',
            'catatan' => 'nullable|string|max:500',
        ]);

        return redirect()->route('dosen.dashboard')
                         ->with('success', 'Status berhasil diperbarui.');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'ruangan'    => 'nullable|string|max:100',
            'no_hp'      => 'nullable|string|max:20',
            'foto_profil'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        return redirect()->route('dosen.dashboard')
                         ->with('success', 'Profil berhasil disimpan.');
    }
}

{
    $requests = [
        (object)[
            'id'        => 1,
            'tanggal'   => '2026-03-15',
            'jam'       => '12:30',
            'mahasiswa' => 'Leon Scott Kennedy',
            'nim'       => '3312401987',
            'topik'     => 'PBL',
            'pesan'     => 'testing',
            'balasan'   => 'oke saya terima',
            'status'    => 'APPROVED',
        ],
    ];

    return view('layouts.dosen.bimbingan', compact('requests'));
}

{
    $request->validate(['balasan' => 'required|string|max:500']);

    // Nanti connect DB:
    // Bimbingan::findOrFail($id)->update([
    //     'status'  => 'APPROVED',
    //     'balasan' => $request->balasan,
    // ]);

    return redirect()->route('dosen.bimbingan')
                     ->with('success', 'Bimbingan berhasil diterima.');
}


{
    $request->validate(['balasan' => 'required|string|max:500']);

    // Nanti connect DB:
    // Bimbingan::findOrFail($id)->update([
    //     'status'  => 'REJECTED',
    //     'balasan' => $request->balasan,
    // ]);

    return redirect()->route('dosen.bimbingan')
                     ->with('success', 'Bimbingan ditolak.');
}

{
    $jadwal = [
        ['id'=>1,'hari'=>'Senin', 'mulai'=>'08:00','selesai'=>'09:00','aktifitas'=>'Mengajar','matakuliah'=>'Algoritma'],
        ['id'=>2,'hari'=>'Senin', 'mulai'=>'08:00','selesai'=>'09:00','aktifitas'=>'Mengajar','matakuliah'=>''],
        ['id'=>3,'hari'=>'Selasa','mulai'=>'08:00','selesai'=>'09:00','aktifitas'=>'Mengajar','matakuliah'=>''],
    ];

    return view('layouts.dosen.jadwal', compact('jadwal'));
}


{
    $request->validate([
        'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        'mulai'      => 'required',
        'selesai'    => 'required',
        'aktifitas'  => 'required|string',
        'matakuliah' => 'nullable|string|max:100',
    ]);

    // Nanti simpan ke DB:
    // Jadwal::create([...$request->only(['hari','mulai','selesai','aktifitas','matakuliah']), 'dosen_id' => Auth::id()]);

    return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
}


    // Nanti hapus dari DB:
    // Jadwal::findOrFail($id)->delete();

    return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil dihapus!');
