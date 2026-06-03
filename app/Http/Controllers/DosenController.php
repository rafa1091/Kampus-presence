<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    /**
     * DASHBOARD UTAMA DOSEN
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil info status dosen langsung dari tabel users (Tanpa JOIN karena semua sudah di tabel users)
        $dosen = DB::table('users')->where('id', $user->id)->first();

        if ($dosen) {
            $labels = [
                'di_ruangan'      => 'Di Ruangan',
                'sedang_mengajar' => 'Sedang Mengajar',
                'sedang_bimbingan'=> 'Sedang Bimbingan',
                'tidak_ada'       => 'Tidak Ada'
            ];
            
            $statusAktif = $dosen->status ?? 'sedang_mengajar';
            $dosen->status = $statusAktif; 
            $dosen->status_label = $labels[$statusAktif] ?? 'Tidak Diketahui';
        }

        // Hitung statistik bimbingan
        $statistik = [
            'pending'  => DB::table('bimbingan')->where('dosen_id', $user->id)->where('status', 'pending')->count(),
            'diterima' => DB::table('bimbingan')->where('dosen_id', $user->id)->where('status', 'approved')->count(),
            'total'    => DB::table('bimbingan')->where('dosen_id', $user->id)->count(),
        ];

        return view('layouts.dosen.dashboard', compact('dosen', 'statistik'));
    }

    /**
     * UPDATE STATUS DOSEN VIA AJAX / MANUAL CLICK
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status'  => 'required|in:di_ruangan,sedang_mengajar,sedang_bimbingan,tidak_ada',
            'catatan' => 'nullable|string|max:500',
        ]);

        DB::table('users')->where('id', Auth::id())->update([
            'status'         => $request->status,
            'catatan_status' => $request->catatan,
            'updated_at'     => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Status berhasil diperbarui secara realtime.'
            ]);
        }

        return redirect()->route('dosen.dashboard')->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * UPDATE PROFIL DOSEN (Hanya satu fungsi, 100% Mengarah ke tabel users)
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'ruangan'     => 'nullable|string|max:100',
            'no_hp'       => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $userId = Auth::id();

        // Siapkan data untuk di-update ke tabel users
        $updateData = [
            'phone'      => $request->no_hp,
            'ruangan'    => $request->ruangan,
            'updated_at' => now(),
        ];

        // Jalankan proses upload foto jika ada
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profil', 'public');
            $updateData['foto_profil'] = $path;
        }

        // Eksekusi update langsung ke tabel users
        DB::table('users')->where('id', $userId)->update($updateData);

        return redirect()->route('dosen.dashboard')->with('success', 'Profil berhasil disimpan.');
    }

    /**
     * HALAMAN PERMINTAAN BIMBINGAN MAHASISWA
     */
    public function bimbingan()
    {
        $user = Auth::user();

        $requests = DB::table('bimbingan')
            ->join('users', 'bimbingan.user_id', '=', 'users.id')
            ->where('bimbingan.dosen_id', $user->id)
            ->select('bimbingan.*', 'users.name as mahasiswa', 'users.nim as nim')
            ->orderBy('bimbingan.id', 'desc')
            ->get();

        $jadwal = DB::table('jadwals')->where('dosen_id', $user->id)->get();

        return view('layouts.dosen.bimbingan', compact('requests', 'jadwal'));
    }

    /**
     * TERIMA BIMBINGAN MAHASISWA
     */
    public function approveBimbingan(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|string|max:500']);

        DB::table('bimbingan')->where('id', $id)->update([
            'status'        => 'approved',
            'catatan_dosen' => $request->balasan,
            'updated_at'    => now(),
        ]);

        return redirect()->route('dosen.bimbingan')->with('success', 'Bimbingan berhasil diterima.');
    }

    /**
     * TOLAK BIMBINGAN MAHASISWA
     */
    public function rejectBimbingan(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|string|max:500']);

        DB::table('bimbingan')->where('id', $id)->update([
            'status'        => 'rejected',
            'catatan_dosen' => $request->balasan,
            'updated_at'    => now(),
        ]);

        return redirect()->route('dosen.bimbingan')->with('success', 'Bimbingan ditolak.');
    }

    /**
     * DAFTAR JADWAL DOSEN
     */
    public function jadwal()
    {
        $jadwal = DB::table('jadwals')->where('dosen_id', Auth::id())->get();
        return view('layouts.dosen.jadwal', compact('jadwal'));
    }

    /**
     * SIMPAN JADWAL BARU
     */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'mulai'      => 'required',
            'selesai'    => 'required',
            'aktifitas'  => 'required|string',
            'matakuliah' => 'nullable|string|max:100',
        ]);

        DB::table('jadwals')->insert([
            'dosen_id'   => Auth::id(),
            'hari'       => $request->hari,
            'mulai'      => $request->mulai,
            'selesai'    => $request->selesai,
            'aktivitas'  => $request->aktifitas, 
            'matakuliah' => $request->matakuliah,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * HAPUS JADWAL
     */
    public function deleteJadwal($id)
    {
        DB::table('jadwals')->where('id', $id)->where('dosen_id', Auth::id())->delete();
        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}