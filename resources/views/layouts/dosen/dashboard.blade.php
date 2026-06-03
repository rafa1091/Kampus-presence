@extends('layouts.app')

@section('title', 'Dashboard Dosen - KAMPUS/presence')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex gap-6">

        {{-- ===================== KOLOM KIRI: STATUS SAYA ===================== --}}
        <div class="flex-1">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 h-full">

                {{-- Header --}}
                <div class="flex justify-between items-start mb-1">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                        STATUS SAYA
                    </span>
                    {{-- Badge Status Utama --}}
                    <span id="badge-status-utama" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all duration-300">
                        <span id="dot-status-utama" class="w-2 h-2 rounded-full inline-block"></span>
                        <span id="text-status-utama">{{ strtoupper($dosen->status_label ?? 'SEDANG MENGAJAR') }}</span>
                    </span>
                </div>

                <h2 class="text-3xl font-extrabold mt-2 mb-1">Halo, {{ $dosen->nama ?? Auth::user()->name }}</h2>
                <p class="text-sm text-gray-400 mb-6">Perbarui status agar mahasiswa tahu keberadaan Anda.</p>

                {{-- Pilihan Status --}}
                <form action="{{ route('dosen.status.update') }}" method="POST" id="formStatus">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap gap-3 mb-6">

                        {{-- Di Ruangan --}}
                        <div id="card-di_ruangan" 
                        onclick="pilihStatus('di_ruangan')" 
                        class="status-card w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-white border-gray-200 text-gray-500 hover:border-black">
                        <span class="w-2 h-2 rounded-full bg-green-500 block mb-4"></span>
                        <span class="text-xs font-bold block mb-1">Di Ruangan</span>
                    </div>

                        {{-- Sedang Mengajar --}}
                        <div id="card-sedang_mengajar"
                             onclick="pilihStatus('sedang_mengajar')"
                             class="w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-white border-gray-200 text-gray-700 hover:border-gray-400">
                            <span class="w-2 h-2 rounded-full bg-orange-400 block mb-4"></span>
                            <span class="text-xs font-bold block mb-1">Sedang Mengajar</span>
                        </div>

                        {{-- Sedang Bimbingan --}}
                        <div id="card-sedang_bimbingan"
                             onclick="pilihStatus('sedang_bimbingan')"
                             class="w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-white border-gray-200 text-gray-700 hover:border-gray-400">
                            <span class="w-2 h-2 rounded-full bg-blue-500 block mb-4"></span>
                            <span class="text-xs font-bold block mb-1">Sedang Bimbingan</span>
                        </div>

                        {{-- Tidak Ada --}}
                        <div id="card-tidak_ada"
                             onclick="pilihStatus('tidak_ada')"
                             class="w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-white border-gray-200 text-gray-700 hover:border-gray-400">
                            <span class="w-2 h-2 rounded-full bg-red-500 block mb-4"></span>
                            <span class="text-xs font-bold block mb-1">Tidak Ada</span>
                        </div>
                    </div>

                    <input type="hidden" name="status" id="inputStatus" value="{{ $dosen->status ?? 'sedang_mengajar' }}">

                    {{-- Catatan Status --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            CATATAN STATUS (OPSIONAL)
                        </label>
                        <textarea name="catatan"
                                  rows="4"
                                  placeholder="Masukkan Catatan..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-300 resize-none focus:outline-none focus:border-gray-400 transition-colors">{{ $dosen->catatan_status ?? '' }}</textarea>
                    </div>
                </form>

            </div>
        </div>

        {{-- ===================== KOLOM KANAN: PROFIL & STATISTIK ===================== --}}
        <div class="w-80 shrink-0">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 h-full flex flex-col justify-between">

                <form action="{{ route('dosen.profil.update') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                    @csrf
                    @method('PUT')

                    {{-- Ruangan --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            RUANGAN
                        </label>
                        <input type="text"
                               name="ruangan"
                               value="{{ $dosen->ruangan ?? '' }}"
                               class="w-full h-11 border border-gray-200 rounded-lg px-3 text-sm text-gray-700 focus:outline-none focus:border-gray-400 transition-colors">
                    </div>

                    {{-- No. HP --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            NO.HP
                        </label>
                        <input type="text"
                               name="no_hp"
                               value="{{ $dosen->no_hp ?? $dosen->phone ?? '' }}"
                               class="w-full h-11 border border-gray-200 rounded-lg px-3 text-sm text-gray-700 focus:outline-none focus:border-gray-400 transition-colors">
                    </div>

                    {{-- Foto Profil --}}
                    <div class="mb-5">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            FOTO PROFIL
                        </label>
                        <input type="file"
                               name="foto_profil"
                               accept="image/*"
                               class="w-full h-11 border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-400 file:hidden cursor-pointer focus:outline-none focus:border-gray-400 pt-3">
                    </div>

                    <button class="w-full h-[38px] px-6 bg-white border-2 border-black text-black font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all">
                        SIMPAN PERUBAHAN
                    </button>
                </form>

                {{-- Kotak Statistik Bersih --}}
                <div class="mt-6">
                    <hr class="my-5 border-gray-200">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-4">
                        STATISTIK BIMBINGAN
                    </p>

                    <div class="flex text-center border border-gray-100 rounded-xl py-3">
                        <div class="flex-1 flex flex-col justify-center items-center">
                            <div class="text-xl font-black text-gray-900 leading-none">{{ $statistik['pending'] }}</div>
                            <div class="text-[8px] font-bold uppercase tracking-widest text-gray-400 mt-1.5 border-t border-gray-200 pt-1 w-10">PENDING</div>
                        </div>
                        <div class="flex-1 border-l border-gray-100 flex flex-col justify-center items-center">
                            <div class="text-xl font-black text-gray-900 leading-none">{{ $statistik['diterima'] }}</div>
                            <div class="text-[8px] font-bold uppercase tracking-widest text-gray-400 mt-1.5 border-t border-gray-200 pt-1 w-10">DITERIMA</div>
                        </div>
                        <div class="flex-1 border-l border-gray-100 flex flex-col justify-center items-center">
                            <div class="text-xl font-black text-gray-900 leading-none">{{ $statistik['total'] }}</div>
                            <div class="text-[8px] font-bold uppercase tracking-widest text-gray-400 mt-1.5 border-t border-gray-200 pt-1 w-10">TOTAL</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT LIVE SYNC KITA TARUH LANGSUNG DI BAWAH TANPA PUSH BIAR PASTI JALAN --}}
<script>
    // Style config untuk sinkronisasi badge atas
    const statusStyles = {
        'di_ruangan': { bg: '#e8f5e9', text: '#2e7d32', border: '#c8e6c9', dot: 'bg-green-500', label: 'DI RUANGAN' },
        'sedang_mengajar': { bg: '#fff3e0', text: '#ea6500', border: '#fbcda0', dot: 'bg-orange-400', label: 'SEDANG MENGAJAR' },
        'sedang_bimbingan': { bg: '#e3f2fd', text: '#1565c0', border: '#bbdefb', dot: 'bg-blue-500', label: 'SEDANG BIMBINGAN' },
        'tidak_ada': { bg: '#ffebee', text: '#c62828', border: '#ffcdd2', dot: 'bg-red-500', label: 'TIDAK ADA' }
    };

    function updateCardUI(statusAktif) {
        const statuses = ['di_ruangan', 'sedang_mengajar', 'sedang_bimbingan', 'tidak_ada'];
        
        statuses.forEach(s => {
            const card = document.getElementById('card-' + s);
            if (card) {
                if (s === statusAktif) {
                    // Jika aktif: latar hitam, teks putih
                    card.className = "w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-gray-900 border-gray-900 text-white shadow-sm";
                } else {
                    // Jika tidak aktif: latar putih, border abu-abu
                    card.className = "w-36 rounded-xl p-4 cursor-pointer transition-all duration-200 border text-left bg-white border-gray-200 text-gray-700 hover:border-gray-400";
                }
            }
        });

        // Sinkronisasi Badge Pojok Kanan Atas
        const badge = document.getElementById('badge-status-utama');
        const dot = document.getElementById('dot-status-utama');
        const text = document.getElementById('text-status-utama');
        const style = statusStyles[statusAktif];

        if (badge && style) {
            badge.style.backgroundColor = style.bg;
            badge.style.color = style.text;
            badge.style.borderColor = style.border;
            if(dot) dot.className = `w-2 h-2 rounded-full inline-block ${style.dot}`;
            if(text) text.textContent = style.label;
        }
    }

    // Fungsi klik status menggunakan Fetch API (Anti-Nyangkut & Tanpa Reload)
    function pilihStatus(status) {
        // 1. Langsung ubah UI di web biar instan & responsif
        updateCardUI(status);

        // 2. Kirim data ke backend Laravel secara background (bukan reload page)
        const form = document.getElementById('formStatus');
        const formData = new FormData(form);
        formData.set('status', status); // timpa status terbaru

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Status updated successfully:', data);
        })
        .catch(error => {
            console.error('Error updating status:', error);
        });
    }

    // Jalankan render awal pas halaman kelar di-load
    window.addEventListener('DOMContentLoaded', () => {
        // Ambil status asli dari backend variable, kalau kosong default ke sedang_mengajar
        const statusAwal = "{{ $dosen->status ?? 'sedang_mengajar' }}";
        updateCardUI(statusAwal);
    });
</script>
@endsection