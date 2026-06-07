@extends('layouts.app')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    /* ─── HERO ─── */
    .bim-hero {
        background: linear-gradient(135deg, #1E2A4A 0%, #2D3F6B 100%);
        padding: 2rem 2rem 3.5rem;
    }
    .bim-hero-inner { max-width: 960px; margin: 0 auto; }
    .bim-hero-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #8AAEFB; text-transform: uppercase; margin-bottom: 0.5rem; }
    .bim-hero-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; }
    .bim-hero-title { font-size: 26px; font-weight: 700; color: #fff; line-height: 1.3; }
    .bim-hero-count { font-size: 12px; color: rgba(255,255,255,.5); }
    .bim-hero-count span { color: #fff; font-weight: 700; font-size: 20px; }

    /* ─── MAIN ─── */
    .bim-main { max-width: 960px; margin: -1.5rem auto 4rem; padding: 0 2rem; position: relative; z-index: 1; }

    /* ─── FILTER TABS ─── */
    .bim-tabs {
        background: #fff; border-radius: 14px; padding: 8px;
        display: flex; gap: 6px; margin-bottom: 1.5rem;
        border: 0.5px solid rgba(0,0,0,.08);
        box-shadow: 0 2px 12px rgba(30,42,74,.06);
        width: fit-content;
    }
    .bim-tab {
        font-size: 11px; font-weight: 700; padding: 7px 16px; border-radius: 8px;
        text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;
        color: #64748B; transition: all .15s;
    }
    .bim-tab:hover { background: #F4F6FB; color: #1E2A4A; }
    .bim-tab.active { background: #1E2A4A; color: #fff; }

    /* ─── ALERT ─── */
    .bim-alert {
        padding: 12px 16px; border-radius: 10px; font-size: 12px; font-weight: 600;
        margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;
    }
    .bim-alert-success { background: #ECFDF5; color: #059669; border: 0.5px solid #A7F3D0; }
    .bim-alert-error   { background: #FEF2F2; color: #B91C1C; border: 0.5px solid #FECACA; }

    /* ─── EMPTY ─── */
    .bim-empty {
        background: #fff; border-radius: 16px; padding: 4rem 2rem;
        text-align: center; border: 0.5px solid rgba(0,0,0,.07);
        box-shadow: 0 2px 10px rgba(30,42,74,.05);
    }
    .bim-empty-icon { font-size: 32px; margin-bottom: 12px; }
    .bim-empty-title { font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
    .bim-empty-sub   { font-size: 12px; color: #94A3B8; }

    /* ─── LIST ─── */
    .bim-list { display: flex; flex-direction: column; gap: 12px; }

    /* ─── CARD ─── */
    .bim-card {
        background: #fff; border-radius: 16px; padding: 20px;
        border: 0.5px solid rgba(0,0,0,.07);
        box-shadow: 0 2px 10px rgba(30,42,74,.05);
        position: relative; overflow: hidden;
        transition: box-shadow .2s;
    }
    .bim-card:hover { box-shadow: 0 6px 20px rgba(30,42,74,.08); }
    .bim-card-accent { position: absolute; top: 0; left: 0; bottom: 0; width: 3px; border-radius: 16px 0 0 16px; }
    .accent-yellow { background: #F59E0B; }
    .accent-green  { background: #10B981; }
    .accent-red    { background: #EF4444; }

    .bim-card-inner { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; padding-left: 12px; }
    .bim-card-body  { flex: 1; }

    /* Badge */
    .bim-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 10px; font-weight: 700; padding: 4px 10px;
        border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .bim-badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-pending  { background: #FFFBEB; color: #B45309; }
    .badge-pending .bim-badge-dot  { background: #F59E0B; }
    .badge-approved { background: #ECFDF5; color: #059669; }
    .badge-approved .bim-badge-dot { background: #10B981; }
    .badge-rejected { background: #FEF2F2; color: #B91C1C; }
    .badge-rejected .bim-badge-dot { background: #EF4444; }

    .bim-time { font-size: 10px; color: #94A3B8; font-weight: 500; margin-left: 8px; }

    .bim-dosen-label { font-size: 10px; color: #94A3B8; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
    .bim-dosen-name  { font-size: 16px; font-weight: 700; color: #1E2A4A; margin-bottom: 4px; }
    .bim-topik       { font-size: 13px; color: #475569; margin-bottom: 12px; }

    .bim-meta { display: flex; gap: 16px; flex-wrap: wrap; }
    .bim-meta-item { display: flex; align-items: center; gap: 6px; font-size: 11px; color: #64748B; font-weight: 600; }
    .bim-meta-item svg { width: 13px; height: 13px; color: #94A3B8; }

    .bim-catatan {
        font-size: 11px; color: #94A3B8; font-style: italic;
        margin-top: 10px; padding: 6px 10px;
        background: #F8FAFC; border-radius: 6px;
        border-left: 2px solid #E2E8F0;
    }

    .bim-catatan-dosen {
        margin-top: 10px; padding: 10px 12px; border-radius: 10px;
        font-size: 12px;
    }
    .bim-catatan-dosen.approved { background: #ECFDF5; border: 0.5px solid #A7F3D0; }
    .bim-catatan-dosen.rejected { background: #FEF2F2; border: 0.5px solid #FECACA; }
    .bim-catatan-dosen-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
    .bim-catatan-dosen.approved .bim-catatan-dosen-label { color: #059669; }
    .bim-catatan-dosen.rejected .bim-catatan-dosen-label { color: #B91C1C; }
    .bim-catatan-dosen-text { color: #475569; }

    /* Batalkan button */
    .bim-cancel-btn {
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        padding: 8px 14px; border-radius: 8px; cursor: pointer;
        border: 0.5px solid #E2E8F0; background: #F8FAFC; color: #94A3B8;
        transition: all .15s; white-space: nowrap; font-family: inherit;
    }
    .bim-cancel-btn:hover { background: #FEF2F2; border-color: #FECACA; color: #EF4444; }
</style>

{{-- ─── HERO ─── --}}
<div class="bim-hero">
    <div class="bim-hero-inner">
        <div class="bim-hero-label">Mahasiswa</div>
        <div class="bim-hero-row">
            <div class="bim-hero-title">Request Bimbingan<br>Saya</div>
            <div class="bim-hero-count">
                <span>{{ $bimbingans->count() }}</span><br>total request
            </div>
        </div>
    </div>
</div>

{{-- ─── MAIN ─── --}}
<div class="bim-main">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bim-alert bim-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bim-alert bim-alert-error">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter Tabs --}}
    <div class="bim-tabs">
        @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
            <a href="{{ route('mahasiswa.bimbingan', ['status' => $key]) }}"
               class="bim-tab {{ $status === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Content --}}
    @if($bimbingans->isEmpty())
        <div class="bim-empty">
            <div class="bim-empty-icon">
                <svg width="32" height="32" fill="none" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="14" x2="16" y2="14"/><line x1="8" y1="18" x2="12" y2="18"/>
                </svg>
            </div>
            <div class="bim-empty-title">Belum ada request bimbingan</div>
            <div class="bim-empty-sub">Klik "Request Bimbingan" di halaman Dashboard</div>
        </div>
    @else
        <div class="bim-list">
            @foreach($bimbingans as $item)
            @php
                $accentMap = ['pending' => 'accent-yellow', 'approved' => 'accent-green', 'rejected' => 'accent-red'];
                $accent    = $accentMap[$item->status] ?? 'accent-yellow';
            @endphp
            <div class="bim-card">
                <div class="bim-card-accent {{ $accent }}"></div>
                <div class="bim-card-inner">
                    <div class="bim-card-body">

                        {{-- Badge + Waktu --}}
                        <div style="display:flex; align-items:center; margin-bottom:10px;">
                            <div class="bim-badge badge-{{ $item->status }}">
                                <div class="bim-badge-dot"></div>
                                {{ ucfirst($item->status) }}
                            </div>
                            <span class="bim-time">{{ $item->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Dosen --}}
                        <div class="bim-dosen-label">Dosen</div>
                        <div class="bim-dosen-name">{{ $item->dosen->nama ?? '-' }}</div>
                        <div class="bim-topik">{{ $item->topik }}</div>

                        {{-- Meta --}}
                        <div class="bim-meta">
                            <div class="bim-meta-item">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </div>
                            <div class="bim-meta-item">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                            </div>
                        </div>

                        {{-- Catatan mahasiswa --}}
                        @if($item->catatan)
                            <div class="bim-catatan">"{{ $item->catatan }}"</div>
                        @endif

                        {{-- Catatan dosen --}}
                        @if($item->catatan_dosen)
                            <div class="bim-catatan-dosen {{ $item->status }}">
                                <div class="bim-catatan-dosen-label">Catatan Dosen</div>
                                <div class="bim-catatan-dosen-text">{{ $item->catatan_dosen }}</div>
                            </div>
                        @endif

                    </div>

                    {{-- Batalkan --}}
                    @if($item->status === 'pending')
                        <form method="POST" action="{{ route('mahasiswa.bimbingan.destroy', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Batalkan request ini?')" class="bim-cancel-btn">
                                Batalkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

@endsection