@extends('layouts.app')

@section('title', 'Jadwal Saya')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10">

<<<<<<< HEAD
<style>
    *, *::before, *::after { box-sizing: border-box; }

    .jdw-hero { background: linear-gradient(135deg, #1E2A4A 0%, #2D3F6B 100%); padding: 2rem 2rem 3.5rem; }
    .jdw-hero-inner { max-width: 960px; margin: 0 auto; }
    .jdw-hero-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #8AAEFB; text-transform: uppercase; margin-bottom: 0.4rem; }
    .jdw-hero-title { font-size: 26px; font-weight: 700; color: #fff; line-height: 1.3; }

    .jdw-main { max-width: 960px; margin: -1.5rem auto 4rem; padding: 0 2rem; position: relative; z-index: 1; }

    /* Alert */
    .jdw-alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .jdw-alert-success { background: #ECFDF5; color: #059669; border: 0.5px solid #A7F3D0; }

    /* Form card */
    .jdw-form-card { background: #fff; border-radius: 16px; padding: 22px; margin-bottom: 20px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 2px 10px rgba(30,42,74,.05); }
    .jdw-form-label-section { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 16px; }

    .jdw-form-grid { display: grid; grid-template-columns: 130px 110px 110px 1fr 1fr; gap: 10px; align-items: end; }
    @media (max-width: 700px) { .jdw-form-grid { grid-template-columns: 1fr 1fr; } }

    .jdw-field-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 6px; display: block; }
    .jdw-input, .jdw-select {
        width: 100%; height: 40px; border: 0.5px solid #E2E8F0; border-radius: 10px;
        padding: 0 12px; font-size: 13px; font-family: inherit;
        color: #1E2A4A; outline: none; transition: border-color .15s; background: #fff;
        appearance: none;
    }
    .jdw-input:focus, .jdw-select:focus { border-color: #4F7EF8; }
    .jdw-select-wrap { position: relative; }
    .jdw-select-wrap svg { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); width: 13px; height: 13px; color: #94A3B8; pointer-events: none; }

    .jdw-btn-add { height: 40px; padding: 0 20px; background: #1E2A4A; color: #fff; border: none; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; font-family: inherit; transition: background .15s; display: flex; align-items: center; gap: 6px; margin-top: 14px; }
    .jdw-btn-add:hover { background: #4F7EF8; }
    .jdw-btn-add svg { width: 14px; height: 14px; }

    /* Grid jadwal */
    .jdw-week-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
    @media (max-width: 600px) { .jdw-week-grid { grid-template-columns: 1fr; } }

    .jdw-day-col {}
    .jdw-day-header { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #1E2A4A; margin-bottom: 8px; padding: 0 2px; }

    .jdw-slot { background: #fff; border-radius: 12px; padding: 12px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 1px 6px rgba(30,42,74,.04); margin-bottom: 8px; position: relative; overflow: hidden; }
    .jdw-slot-accent { position: absolute; top: 0; left: 0; bottom: 0; width: 3px; border-radius: 12px 0 0 12px; }
    .accent-mengajar  { background: #F59E0B; }
    .accent-bimbingan { background: #4F7EF8; }
    .accent-rapat     { background: #10B981; }
    .accent-lainnya   { background: #94A3B8; }

    .jdw-slot-inner { padding-left: 10px; }
    .jdw-slot-time  { font-size: 11px; font-weight: 700; color: #1E2A4A; }
    .jdw-slot-act   { font-size: 12px; font-weight: 600; color: #475569; margin-top: 2px; }
    .jdw-slot-mk    { font-size: 10px; color: #94A3B8; margin-top: 2px; }

    .jdw-btn-hapus { display: flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94A3B8; background: none; border: none; cursor: pointer; padding: 0; margin-top: 8px; font-family: inherit; transition: color .15s; }
    .jdw-btn-hapus:hover { color: #EF4444; }
    .jdw-btn-hapus svg { width: 11px; height: 11px; }

    .jdw-empty { background: #fff; border-radius: 12px; padding: 16px; text-align: center; border: 0.5px dashed #E2E8F0; }
    .jdw-empty-text { font-size: 11px; color: #CBD5E1; font-weight: 500; }
</style>

{{-- HERO --}}
<div class="jdw-hero">
    <div class="jdw-hero-inner">
        <div class="jdw-hero-label">Jadwal Mingguan</div>
        <div class="jdw-hero-title">Atur Jadwal Anda</div>
    </div>
</div>

{{-- MAIN --}}
<div class="jdw-main">

    @if(session('success'))
        <div class="jdw-alert jdw-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah --}}
    <div class="jdw-form-card">
        <div class="jdw-form-label-section">Tambah Jadwal Baru</div>

        <form action="{{ route('dosen.jadwal.store') }}" method="POST">
            @csrf
            <div class="jdw-form-grid">

                {{-- Hari --}}
                <div>
                    <label class="jdw-field-label">Hari</label>
                    <div class="jdw-select-wrap">
                        <select name="hari" class="jdw-select">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari') === $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- Mulai --}}
                <div>
                    <label class="jdw-field-label">Mulai</label>
                    <input type="time" name="mulai" value="{{ old('mulai') }}" class="jdw-input">
                </div>

                {{-- Selesai --}}
                <div>
                    <label class="jdw-field-label">Selesai</label>
                    <input type="time" name="selesai" value="{{ old('selesai') }}" class="jdw-input">
                </div>

                {{-- Aktifitas --}}
                <div>
                    <label class="jdw-field-label">Aktifitas</label>
                    <div class="jdw-select-wrap">
                        <select name="aktifitas" class="jdw-select">
                            <option value="Mengajar">Mengajar</option>
                            <option value="Bimbingan">Bimbingan</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- Matakuliah --}}
                <div>
                    <label class="jdw-field-label">Matakuliah <span style="font-weight:400;text-transform:none;letter-spacing:0">(Opsional)</span></label>
                    <input type="text" name="matakuliah" value="{{ old('matakuliah') }}" placeholder="Contoh: Algoritma" class="jdw-input">
                </div>

            </div>

            <button type="submit" class="jdw-btn-add">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Jadwal
            </button>
        </form>
    </div>

    {{-- Grid Mingguan --}}
    @php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $accentMap = [
            'mengajar'  => 'accent-mengajar',
            'bimbingan' => 'accent-bimbingan',
            'rapat'     => 'accent-rapat',
            'lainnya'   => 'accent-lainnya',
        ];

        // Support array atau collection dari DB
        $jadwalPerHari = [];
        foreach ($hariList as $h) {
            if (is_array($jadwal ?? null)) {
                $jadwalPerHari[$h] = collect($jadwal)->filter(fn($j) => ($j['hari'] ?? '') === $h)->values();
            } else {
                $jadwalPerHari[$h] = ($jadwal[$h] ?? collect());
            }
        }
    @endphp

    <div class="jdw-week-grid">
        @foreach($hariList as $hari)
        <div class="jdw-day-col">
            <div class="jdw-day-header">{{ $hari }}</div>

            @forelse($jadwalPerHari[$hari] as $j)
            @php
                $act    = is_array($j) ? ($j['aktifitas'] ?? '') : ($j->aktifitas ?? '');
                $mulai  = is_array($j) ? ($j['mulai'] ?? '') : ($j->mulai ?? '');
                $selesai= is_array($j) ? ($j['selesai'] ?? '') : ($j->selesai ?? '');
                $mk     = is_array($j) ? ($j['matakuliah'] ?? '') : ($j->matakuliah ?? '');
                $jid    = is_array($j) ? ($j['id'] ?? 0) : ($j->id ?? 0);
                $accent = $accentMap[strtolower($act)] ?? 'accent-lainnya';
            @endphp
            <div class="jdw-slot">
                <div class="jdw-slot-accent {{ $accent }}"></div>
                <div class="jdw-slot-inner">
                    <div class="jdw-slot-time">{{ substr($mulai,0,5) }} – {{ substr($selesai,0,5) }}</div>
                    <div class="jdw-slot-act">{{ $act }}</div>
                    @if($mk)
                        <div class="jdw-slot-mk">{{ $mk }}</div>
                    @endif
                    <form action="{{ route('dosen.jadwal.destroy', $jid) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus jadwal ini?')" class="jdw-btn-hapus">
                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="jdw-empty">
                <div class="jdw-empty-text">kosong</div>
            </div>
            @endforelse
        </div>
        @endforeach
    </div>
=======
    {{-- Header --}}
    <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 mb-1">Jadwal Mingguan</p>
        <h1 class="text-[28px] font-extrabold tracking-tight leading-none">Atur Jadwal Anda</h1>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[13px] text-green-700 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Jadwal --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-8">
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Tambah Jadwal Baru</p>

        <form action="{{ route('dosen.jadwal.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-[140px_120px_120px_1fr_1fr] gap-3 items-end">

                {{-- Hari --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Hari</label>
                    <div class="relative">
                        <select name="hari" id="select-hari"
                            onchange="updateHariDisplay()"
                            class="w-full appearance-none border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[13px] text-[#0a0a0a] outline-none focus:border-gray-500 bg-white cursor-pointer transition-colors">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') === $hari ? 'selected' : '' }}>{{ strtoupper($hari) }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Mulai --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Mulai</label>
                    <input type="time" name="mulai" value="{{ old('mulai') }}"
                        class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[13px] text-[#0a0a0a] outline-none focus:border-gray-500 transition-colors">
                </div>
>>>>>>> 95bf4bc52e36fc6bb8a48813aaad040541dd6572

                {{-- Selesai --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Selesai</label>
                    <input type="time" name="selesai" value="{{ old('selesai') }}"
                        class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[13px] text-[#0a0a0a] outline-none focus:border-gray-500 transition-colors">
                </div>

                {{-- Aktifitas --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Aktifitas</label>
                    <div class="relative">
                        <select name="aktifitas"
                            class="w-full appearance-none border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[13px] text-[#0a0a0a] outline-none focus:border-gray-500 bg-white cursor-pointer transition-colors">
                            <option value="Mengajar">Mengajar</option>
                            <option value="Bimbingan">Bimbingan</option>
                            <option value="Rapat">Rapat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Matakuliah --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Matakuliah <span class="normal-case tracking-normal font-normal">(Opsional)</span></label>
                    <input type="text" name="matakuliah" value="{{ old('matakuliah') }}" placeholder="Contoh: Algoritma"
                        class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[13px] text-[#0a0a0a] outline-none focus:border-gray-500 placeholder-gray-300 transition-colors">
                </div>
            </div>

            {{-- Tombol Tambah --}}
            <div class="mt-4">
                <button type="submit"
                    class="px-5 py-2.5 bg-[#0a0a0a] text-white text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2">
                    <span class="text-[14px] leading-none">+</span> Tambah
                </button>
            </div>
        </form>
    </div>

    {{-- Grid Jadwal Mingguan --}}
    @php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Kelompokkan jadwal per hari
        $jadwalPerHari = [];
        foreach ($hariList as $h) {
            $jadwalPerHari[$h] = collect($jadwal ?? [])->filter(fn($j) => $j['hari'] === $h)->values();
        }
    @endphp

    <div class="grid grid-cols-5 gap-3">
        @foreach($hariList as $hari)
        <div class="flex flex-col gap-2">

            {{-- Header Hari --}}
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#0a0a0a] mb-1">{{ strtoupper($hari) }}</p>

            {{-- Card jadwal --}}
            @forelse($jadwalPerHari[$hari] as $j)
            <div class="bg-white border border-gray-200 rounded-xl p-3">
                <p class="text-[12px] font-bold text-[#0a0a0a]">
                    {{ substr($j['mulai'], 0, 5) }}-{{ substr($j['selesai'], 0, 5) }}
                </p>
                <p class="text-[12px] font-semibold text-[#0a0a0a] mt-0.5">{{ $j['aktifitas'] }}</p>

                @if(!empty($j['matakuliah']))
                <p class="text-[10px] text-gray-400 mt-0.5">{{ $j['matakuliah'] }}</p>
                @endif

                {{-- Tombol Hapus --}}
                <form action="{{ route('dosen.jadwal.destroy', $j['id']) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Hapus jadwal ini?')"
                        class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition-colors">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
            @empty
            <div class="bg-white border border-dashed border-gray-200 rounded-xl p-4 text-center">
                <p class="text-[11px] text-gray-300 font-medium">kosong</p>
            </div>
            @endforelse

        </div>
        @endforeach
    </div>
</div>
@endsection