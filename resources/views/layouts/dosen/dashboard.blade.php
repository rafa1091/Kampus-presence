@extends('layouts.app')

@section('title', 'Dashboard Dosen - KAMPUS/presence')

@section('content')

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

@endsection