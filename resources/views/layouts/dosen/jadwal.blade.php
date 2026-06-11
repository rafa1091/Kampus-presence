@extends('layouts.app')

@section('title', 'Jadwal Saya')

@section('content')

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
    .jdw-alert-danger { background: #FEF2F2; color: #EF4444; border: 0.5px solid #FEE2E2; }

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
        appearance: none; -webkit-appearance: none;
    }
    .jdw-input:focus, .jdw-select:focus { border-color: #4F7EF8; }
    .jdw-select-wrap { position: relative; }
    .jdw-select-wrap svg { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); width: 13px; height: 13px; color: #94A3B8; pointer-events: none; }

    .jdw-btn-add { height: 40px; padding: 0 20px; background: #1E2A4A; color: #fff; border: none; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; font-family: inherit; transition: background .15s; display: flex; align-items: center; gap: 6px; margin-top: 14px; }
    .jdw-btn-add:hover { background: #4F7EF8; }
    .jdw-btn-add svg { width: 14px; height: 14px; }

    /* Grid jadwal */
    .jdw-week-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
    @media (max-width: 800px) { .jdw-week-grid { grid-template-columns: 1fr; } }

    .jdw-day-col {}
    .jdw-day-header { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #1E2A4A; margin-bottom: 8px; padding: 0 2px; border-bottom: 2px solid #E2E8F0; padding-bottom: 4px; }

    .jdw-slot { background: #fff; border-radius: 12px; padding: 12px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 1px 6px rgba(30,42,74,.04); margin-bottom: 8px; position: relative; overflow: hidden; }
    .jdw-slot-accent { position: absolute; top: 0; left: 0; bottom: 0; width: 4px; border-radius: 12px 0 0 12px; }
    .accent-mengajar  { background: #F59E0B; }
    .accent-bimbingan { background: #4F7EF8; }
    .accent-rapat     { background: #10B981; }
    .accent-lainnya   { background: #94A3B8; }

    .jdw-slot-inner { padding-left: 6px; }
    .jdw-slot-time  { font-size: 11px; font-weight: 700; color: #1E2A4A; }
    .jdw-slot-act   { font-size: 12px; font-weight: 600; color: #475569; margin-top: 2px; }
    .jdw-slot-mk    { font-size: 10px; color: #94A3B8; margin-top: 2px; }

    .jdw-btn-hapus { display: flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94A3B8; background: none; border: none; cursor: pointer; padding: 0; margin-top: 10px; font-family: inherit; transition: color .15s; width: 100%; }
    .jdw-btn-hapus:hover { color: #EF4444; }
    .jdw-btn-hapus svg { width: 11px; height: 11px; }

    .jdw-empty { background: #fff; border-radius: 12px; padding: 16px; text-align: center; border: 0.5px dashed #E2E8F0; }
    .jdw-empty-text { font-size: 11px; color: #CBD5E1; font-weight: 500; text-transform: lowercase; }
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

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="jdw-alert jdw-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Alert Validation Errors --}}
    @if($errors->any())
        <div class="jdw-alert jdw-alert-danger">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Ada kesalahan pengisian data. Silakan cek kembali form Anda.</span>
        </div>
    @endif

    {{-- Form Tambah --}}
    <div class="jdw-form-card">
        <div class="jdw-form-label-section">Tambah Jadwal Baru</div>

        <form action="{{ route('dosen.storeJadwal') }}" method="POST">
            @csrf
            <div class="jdw-form-grid">

                {{-- Hari --}}
                <div>
                    <label class="jdw-field-label">Hari</label>
                    <div class="jdw-select-wrap">
                        <select name="hari" class="jdw-select" required>
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
                    <input type="time" name="mulai" value="{{ old('mulai') }}" class="jdw-input" required>
                </div>

                {{-- Selesai --}}
                <div>
                    <label class="jdw-field-label">Selesai</label>
                    <input type="time" name="selesai" value="{{ old('selesai') }}" class="jdw-input" required>
                </div>

                {{-- Aktifitas --}}
                <div>
                    <label class="jdw-field-label">Aktifitas</label>
                    <div class="jdw-select-wrap">
                        <select name="aktifitas" class="jdw-select" required>
                            <option value="mengajar" {{ old('aktifitas') === 'mengajar' ? 'selected' : '' }}>Mengajar</option>
                            <option value="bimbingan" {{ old('aktifitas') === 'bimbingan' ? 'selected' : '' }}>Bimbingan</option>
                            <option value="rapat" {{ old('aktifitas') === 'rapat' ? 'selected' : '' }}>Rapat</option>
                            <option value="lainnya" {{ old('aktifitas') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                    <div class="jdw-slot-act">{{ ucfirst($act) }}</div>
                    @if($mk)
                        <div class="jdw-slot-mk">{{ $mk }}</div>
                    @endif
                    
                    <form action="{{ route('dosen.destroyJadwal', $jid) }}" method="POST">
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

</div>

@endsection