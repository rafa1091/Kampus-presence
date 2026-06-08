<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD

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
=======
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
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572

        return redirect()->route('dosen.dashboard')->with('success', 'Profil berhasil disimpan.');
    }

<<<<<<< HEAD
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

=======
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
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'mulai'      => 'required',
            'selesai'    => 'required',
            'aktifitas'  => 'required|string',
            'matakuliah' => 'nullable|string|max:100',
        ]);

<<<<<<< HEAD
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
=======
        DB::table('jadwals')->insert([
            'dosen_id'   => Auth::id(),
            'hari'       => $request->hari,
            'mulai'      => $request->mulai,
            'selesai'    => $request->selesai,
            'aktivitas'  => $request->aktifitas, 
            'matakuliah' => $request->matakuliah,
            'created_at' => now(),
            'updated_at' => now(),
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
        ]);

        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

<<<<<<< HEAD
    public function destroyJadwal($id)
    {
        $dosen  = $this->getDosen();
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->dosen_id !== $dosen->id) abort(403);

        $jadwal->delete();

=======
    /**
     * HAPUS JADWAL
     */
    public function deleteJadwal($id)
    {
        DB::table('jadwals')->where('id', $id)->where('dosen_id', Auth::id())->delete();
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
        return redirect()->route('dosen.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}