<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosen = (object)[
            'nama' => 'Hamdani',
            'status' => 'Sedang Mengajar',
            'ruangan' => 'Ruang 701',
            'no_hp' => '0897865645'
        ];

        return view('dosen.dashboard', compact('dosen'));
    }

    public function jadwal()
    {
        $jadwal = [
            ['hari' => 'Senin', 'mulai' => '08:00', 'selesai' => '10:00', 'aktivitas' => 'Mengajar'],
            ['hari' => 'Selasa', 'mulai' => '08:00', 'selesai' => '10:00', 'aktivitas' => 'Bimbingan'],
        ];

        return view('jadwal', compact('jadwal'));
    }

    public function bimbingan()
    {
        $requests = [
            (object)[
                'tanggal' => '2026-03-15',
                'jam' => '12:30',
                'mahasiswa' => 'Leon Scott Kennedy',
                'nim' => '3312401987',
                'topik' => 'PBL',
                'pesan' => 'testing',
                'balasan' => 'oke saya terima',
                'status' => 'APPROVED'
            ]
        ];

        return view('bimbingan', compact('requests'));
    }

    public function updateStatus(Request $request)
    {
        // nanti ini nyambung DB
        return response()->json([
            'message' => 'Status updated',
            'status' => $request->status
        ]);
    }
}