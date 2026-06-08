@extends('layouts.app')

@section('title', 'Dashboard Dosen - KAMPUS/presence')

@section('content')
<<<<<<< HEAD

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .ds-hero {
        background: linear-gradient(135deg, #1E2A4A 0%, #2D3F6B 100%);
        padding: 2rem 2rem 3.5rem;
    }
    .ds-hero-inner { max-width: 960px; margin: 0 auto; }
    .ds-hero-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #8AAEFB; text-transform: uppercase; margin-bottom: 0.4rem; }
    .ds-hero-name  { font-size: 26px; font-weight: 700; color: #fff; line-height: 1.3; margin-bottom: 4px; }
    .ds-hero-sub   { font-size: 13px; color: rgba(255,255,255,.45); margin-bottom: 1.5rem; }

    /* Status badge di hero */
    .ds-status-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        background: rgba(255,255,255,.1); border: 0.5px solid rgba(255,255,255,.2); color: #fff;
    }
    .ds-status-dot { width: 7px; height: 7px; border-radius: 50%; }

    .ds-main { max-width: 960px; margin: -1.5rem auto 4rem; padding: 0 2rem; position: relative; z-index: 1; }
    .ds-grid { display: grid; grid-template-columns: 1fr 280px; gap: 16px; }
    @media (max-width: 700px) { .ds-grid { grid-template-columns: 1fr; } }

    .ds-card {
        background: #fff; border-radius: 16px; padding: 24px;
        border: 0.5px solid rgba(0,0,0,.07);
        box-shadow: 0 2px 10px rgba(30,42,74,.05);
    }
    .ds-card-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 16px; }

    /* Status pilihan */
    .ds-status-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 20px; }
    @media (min-width: 500px) { .ds-status-grid { grid-template-columns: repeat(4, 1fr); } }

    .ds-status-card {
        border-radius: 12px; padding: 14px 10px; text-align: center;
        cursor: pointer; transition: all .2s;
        border: 0.5px solid #E2E8F0; background: #F8FAFC; color: #64748B;
    }
    .ds-status-card:hover { border-color: #CBD5E1; background: #F1F5F9; }
    .ds-status-card.active { background: #1E2A4A; border-color: #1E2A4A; color: #fff; }
    .ds-status-card .dot { width: 8px; height: 8px; border-radius: 50%; margin: 0 auto 8px; }
    .ds-status-card .label { font-size: 12px; font-weight: 600; }

    /* Textarea catatan */
    .ds-textarea {
        width: 100%; border: 0.5px solid #E2E8F0; border-radius: 10px;
        padding: 10px 14px; font-size: 13px; font-family: inherit;
        color: #1E2A4A; resize: none; outline: none;
        transition: border-color .15s; background: #fff;
    }
    .ds-textarea:focus { border-color: #4F7EF8; }
    .ds-textarea::placeholder { color: #94A3B8; }

    /* Input profil */
    .ds-input-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 6px; display: block; }
    .ds-input {
        width: 100%; height: 40px; border: 0.5px solid #E2E8F0; border-radius: 10px;
        padding: 0 12px; font-size: 13px; font-family: inherit;
        color: #1E2A4A; outline: none; transition: border-color .15s; background: #fff;
    }
    .ds-input:focus { border-color: #4F7EF8; }

    .ds-btn {
        width: 100%; height: 42px; background: #1E2A4A; color: #fff;
        border: none; border-radius: 10px; font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer;
        font-family: inherit; transition: background .15s; margin-top: 16px;
    }
    .ds-btn:hover { background: #4F7EF8; }
    .ds-btn-outline {
        width: 100%; height: 42px; background: #F4F6FB; color: #1E2A4A;
        border: 0.5px solid #E2E8F0; border-radius: 10px; font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer;
        font-family: inherit; transition: all .15s; margin-top: 10px;
    }
    .ds-btn-outline:hover { background: #EEF3FE; border-color: #4F7EF8; color: #4F7EF8; }

    /* Divider */
    .ds-divider { border: none; border-top: 0.5px solid #F1F5F9; margin: 18px 0; }

    /* Statistik */
    .ds-stats { display: flex; text-align: center; }
    .ds-stat-item { flex: 1; }
    .ds-stat-item + .ds-stat-item { border-left: 0.5px solid #F1F5F9; }
    .ds-stat-num   { font-size: 24px; font-weight: 800; color: #1E2A4A; }
    .ds-stat-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-top: 2px; }

    /* Alert */
    .ds-alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .ds-alert-success { background: #ECFDF5; color: #059669; border: 0.5px solid #A7F3D0; }
    .ds-alert-error   { background: #FEF2F2; color: #B91C1C; border: 0.5px solid #FECACA; }

    /* Foto preview */
    .ds-foto-preview { width: 100%; height: 80px; object-fit: cover; border-radius: 10px; border: 0.5px solid #E2E8F0; margin-bottom: 8px; }
    .ds-file-input { width: 100%; font-size: 12px; color: #64748B; }
</style>

{{-- HERO --}}
<div class="ds-hero">
    <div class="ds-hero-inner">
        <div class="ds-hero-label">Dashboard Dosen</div>
        <div class="ds-hero-name">Halo, {{ $dosen->nama ?? Auth::user()->name }}</div>
        <div class="ds-hero-sub">Perbarui status agar mahasiswa tahu keberadaan Anda.</div>

        @php
            $statusPill = [
                'di_ruangan' => ['dot' => '#10B981', 'label' => 'Di Ruangan'],
                'mengajar'   => ['dot' => '#F59E0B', 'label' => 'Sedang Mengajar'],
                'bimbingan'  => ['dot' => '#4F7EF8', 'label' => 'Sedang Bimbingan'],
                'tidak_ada'  => ['dot' => '#EF4444', 'label' => 'Tidak Ada'],
            ];
            $pill = $statusPill[$dosen->status ?? 'tidak_ada'] ?? $statusPill['tidak_ada'];
        @endphp
        <div class="ds-status-pill">
            <span class="ds-status-dot" style="background: {{ $pill['dot'] }}"></span>
            {{ $pill['label'] }}
        </div>
    </div>
</div>

{{-- MAIN --}}
<div class="ds-main">

    @if(session('success'))
        <div class="ds-alert ds-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ds-alert ds-alert-error">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="ds-grid">

        {{-- KOLOM KIRI: STATUS --}}
        <div class="ds-card">
            <div class="ds-card-label">Status Saya</div>

            <form action="{{ route('dosen.status.update') }}" method="POST" id="formStatus">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="inputStatus" value="{{ $dosen->status ?? '' }}">

                <div class="ds-status-grid">
                    <div id="card-di_ruangan" onclick="pilihStatus('di_ruangan', this)"
                         class="ds-status-card {{ ($dosen->status ?? '') === 'di_ruangan' ? 'active' : '' }}">
                        <div class="dot" style="background:#10B981;"></div>
                        <div class="label">Di Ruangan</div>
                    </div>
                    <div id="card-mengajar" onclick="pilihStatus('mengajar', this)"
                         class="ds-status-card {{ ($dosen->status ?? '') === 'mengajar' ? 'active' : '' }}">
                        <div class="dot" style="background:#F59E0B;"></div>
                        <div class="label">Mengajar</div>
                    </div>
                    <div id="card-bimbingan" onclick="pilihStatus('bimbingan', this)"
                         class="ds-status-card {{ ($dosen->status ?? '') === 'bimbingan' ? 'active' : '' }}">
                        <div class="dot" style="background:#4F7EF8;"></div>
                        <div class="label">Bimbingan</div>
                    </div>
                    <div id="card-tidak_ada" onclick="pilihStatus('tidak_ada', this)"
                         class="ds-status-card {{ ($dosen->status ?? '') === 'tidak_ada' ? 'active' : '' }}">
                        <div class="dot" style="background:#EF4444;"></div>
                        <div class="label">Tidak Ada</div>
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label class="ds-input-label">Catatan Status (Opsional)</label>
                    <textarea name="catatan" rows="4" placeholder="Masukkan catatan..." class="ds-textarea">{{ $dosen->catatan ?? '' }}</textarea>
                </div>

                <button type="submit" class="ds-btn">Simpan Status</button>
            </form>
        </div>

        {{-- KOLOM KANAN: PROFIL & STATISTIK --}}
        <div>
            <div class="ds-card" style="margin-bottom:16px;">
                <div class="ds-card-label">Profil Saya</div>

                <form action="{{ route('dosen.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:12px;">
                        <label class="ds-input-label">Ruangan</label>
                        <input type="text" name="ruangan" value="{{ $dosen->ruangan ?? '' }}" class="ds-input" placeholder="mis. Ruang 301">
                        @error('ruangan')<small style="color:#EF4444;font-size:11px;margin-top:4px;display:block;">{{ $message }}</small>@enderror
                    </div>

                    <div style="margin-bottom:12px;">
                        <label class="ds-input-label">No. HP</label>
                        <input type="text" name="no_hp" value="{{ $dosen->no_hp ?? '' }}" class="ds-input" placeholder="08xxxxxxxxxx">
                        @error('no_hp')<small style="color:#EF4444;font-size:11px;margin-top:4px;display:block;">{{ $message }}</small>@enderror
                    </div>

                    <div style="margin-bottom:4px;">
                        <label class="ds-input-label">Foto Profil</label>
                        @if($dosen->foto ?? null)
                            <img src="{{ asset('storage/' . $dosen->foto) }}" alt="Foto" class="ds-foto-preview">
                        @endif
                        <input type="file" name="foto_profil" accept="image/*" class="ds-file-input">
                        @error('foto_profil')<small style="color:#EF4444;font-size:11px;margin-top:4px;display:block;">{{ $message }}</small>@enderror
                    </div>

                    <button type="submit" class="ds-btn">Simpan Profil</button>
                </form>
            </div>

            {{-- STATISTIK --}}
            <div class="ds-card">
                <div class="ds-card-label">Statistik Bimbingan</div>
                <div class="ds-stats">
                    <div class="ds-stat-item">
                        <div class="ds-stat-num">{{ $statistik['pending'] ?? 0 }}</div>
                        <div class="ds-stat-label">Pending</div>
                    </div>
                    <div class="ds-stat-item">
                        <div class="ds-stat-num">{{ $statistik['diterima'] ?? 0 }}</div>
                        <div class="ds-stat-label">Diterima</div>
                    </div>
                    <div class="ds-stat-item">
                        <div class="ds-stat-num">{{ $statistik['total'] ?? 0 }}</div>
                        <div class="ds-stat-label">Total</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function pilihStatus(status, el) {
    const statuses = ['di_ruangan', 'mengajar', 'bimbingan', 'tidak_ada'];
    statuses.forEach(s => {
        document.getElementById('card-' + s).classList.remove('active');
    });
    el.classList.add('active');
    document.getElementById('inputStatus').value = status;
    document.getElementById('formStatus').submit();
}
</script>
@endpush

=======
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
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572
@endsection