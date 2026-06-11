@extends('layouts.app')

@section('title', 'Aktivitas Saya')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .akt-hero { background: linear-gradient(135deg, #1E2A4A 0%, #2D3F6B 100%); padding: 2rem 2rem 3.5rem; }
    .akt-hero-inner { max-width: 960px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
    .akt-hero-left {}
    .akt-hero-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #8AAEFB; text-transform: uppercase; margin-bottom: 0.4rem; }
    .akt-hero-title { font-size: 26px; font-weight: 700; color: #fff; line-height: 1.3; }

    /* Status Toggle */
    .akt-status-wrap { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
    .akt-status-label { font-size: 10px; font-weight: 700; letter-spacing: 1px; color: #8AAEFB; text-transform: uppercase; }
    .akt-status-btns { display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end; }
    .akt-status-btn { font-size: 10px; font-weight: 700; padding: 6px 14px; border-radius: 20px; border: 1.5px solid rgba(255,255,255,.2); background: rgba(255,255,255,.08); color: rgba(255,255,255,.6); cursor: pointer; font-family: inherit; transition: all .15s; text-transform: uppercase; letter-spacing: 0.5px; }
    .akt-status-btn:hover { background: rgba(255,255,255,.15); color: #fff; }
    .akt-status-btn.active-di_ruangan  { background: #10B981; border-color: #10B981; color: #fff; }
    .akt-status-btn.active-mengajar    { background: #F59E0B; border-color: #F59E0B; color: #fff; }
    .akt-status-btn.active-bimbingan   { background: #4F7EF8; border-color: #4F7EF8; color: #fff; }
    .akt-status-btn.active-tidak_ada   { background: #64748B; border-color: #64748B; color: #fff; }

    .akt-main { max-width: 960px; margin: -1.5rem auto 4rem; padding: 0 2rem; position: relative; z-index: 1; }

    /* Alert */
    .akt-alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .akt-alert-success { background: #ECFDF5; color: #059669; border: 0.5px solid #A7F3D0; }

    /* Stat cards */
    .akt-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
    @media (max-width: 600px) { .akt-stats { grid-template-columns: 1fr; } }
    .akt-stat { background: #fff; border-radius: 16px; padding: 20px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 2px 10px rgba(30,42,74,.05); }
    .akt-stat-num   { font-size: 32px; font-weight: 800; color: #1E2A4A; line-height: 1; }
    .akt-stat-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-top: 6px; }
    .akt-stat-dot   { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
    .dot-approved { background: #10B981; }
    .dot-pending  { background: #F59E0B; }
    .dot-rejected { background: #EF4444; }

    /* Section title */
    .akt-section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 12px; margin-top: 24px; }

    /* Bimbingan hari ini */
    .akt-today-empty { background: #fff; border-radius: 12px; padding: 24px; text-align: center; border: 0.5px dashed #E2E8F0; }
    .akt-today-empty-text { font-size: 12px; color: #CBD5E1; font-weight: 500; }

    .akt-today-list { display: flex; flex-direction: column; gap: 10px; }
    .akt-today-card { background: #fff; border-radius: 12px; padding: 14px 18px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 1px 6px rgba(30,42,74,.04); display: flex; align-items: center; gap: 16px; }
    .akt-today-time { flex-shrink: 0; font-size: 13px; font-weight: 800; color: #1E2A4A; min-width: 48px; }
    .akt-today-info { flex: 1; min-width: 0; }
    .akt-today-name  { font-size: 13px; font-weight: 700; color: #1E2A4A; }
    .akt-today-topik { font-size: 11px; color: #94A3B8; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .akt-today-badge { flex-shrink: 0; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; background: #ECFDF5; color: #059669; text-transform: uppercase; }

    /* Antrian pending */
    .akt-pending-list { display: flex; flex-direction: column; gap: 10px; }
    .akt-pending-card { background: #fff; border-radius: 12px; padding: 14px 18px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 1px 6px rgba(30,42,74,.04); display: flex; align-items: center; gap: 16px; }
    .akt-pending-info { flex: 1; min-width: 0; }
    .akt-pending-name  { font-size: 13px; font-weight: 700; color: #1E2A4A; }
    .akt-pending-meta  { font-size: 11px; color: #94A3B8; margin-top: 2px; }
    .akt-pending-badge { flex-shrink: 0; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; background: #FFFBEB; color: #B45309; text-transform: uppercase; }
    .akt-pending-action { flex-shrink: 0; }
    .akt-btn-balas { font-size: 10px; font-weight: 700; padding: 6px 14px; border-radius: 8px; background: #1E2A4A; color: #fff; border: none; cursor: pointer; font-family: inherit; text-decoration: none; display: inline-block; transition: background .15s; }
    .akt-btn-balas:hover { background: #4F7EF8; }
</style>

{{-- HERO --}}
<div class="akt-hero">
    <div class="akt-hero-inner">
        <div class="akt-hero-left">
            <div class="akt-hero-label">Dosen</div>
            <div class="akt-hero-title">Aktivitas Saya</div>
        </div>

        {{-- Status Toggle --}}
        <div class="akt-status-wrap">
            <div class="akt-status-label">Status Sekarang</div>
            <div class="akt-status-btns">
                @php
                    $statusList = [
                        'di_ruangan' => 'Di Ruangan',
                        'mengajar'   => 'Mengajar',
                        'bimbingan'  => 'Bimbingan',
                        'tidak_ada'  => 'Tidak Ada',
                    ];
                @endphp
                @foreach($statusList as $val => $label)
                    <form method="POST" action="{{ route('dosen.status.update') }}" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ $val }}">
                        <button type="submit" class="akt-status-btn {{ $dosenStatus === $val ? 'active-'.$val : '' }}">
                            {{ $label }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- MAIN --}}
<div class="akt-main">

    @if(session('success'))
        <div class="akt-alert akt-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stat Cards --}}
    <div class="akt-stats">
        <div class="akt-stat">
            <div class="akt-stat-num">{{ $totalApproved }}</div>
            <div class="akt-stat-label"><span class="akt-stat-dot dot-approved"></span>Disetujui</div>
        </div>
        <div class="akt-stat">
            <div class="akt-stat-num">{{ $totalPending }}</div>
            <div class="akt-stat-label"><span class="akt-stat-dot dot-pending"></span>Menunggu</div>
        </div>
        <div class="akt-stat">
            <div class="akt-stat-num">{{ $totalRejected }}</div>
            <div class="akt-stat-label"><span class="akt-stat-dot dot-rejected"></span>Ditolak</div>
        </div>
    </div>

    {{-- Bimbingan Hari Ini --}}
    <div class="akt-section-title">Bimbingan Hari Ini</div>
    @if($hariIni->isEmpty())
        <div class="akt-today-empty">
            <div class="akt-today-empty-text">Tidak ada bimbingan hari ini</div>
        </div>
    @else
        <div class="akt-today-list">
            @foreach($hariIni as $b)
                <div class="akt-today-card">
                    <div class="akt-today-time">{{ substr($b->jam, 0, 5) }}</div>
                    <div class="akt-today-info">
                        <div class="akt-today-name">{{ $b->user->name ?? '-' }}</div>
                        <div class="akt-today-topik">{{ $b->topik }}</div>
                    </div>
                    <div class="akt-today-badge">Approved</div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Antrian Pending --}}
    @if($pending->isNotEmpty())
        <div class="akt-section-title">Menunggu Respons <span style="color:#F59E0B;">({{ $pending->count() }})</span></div>
        <div class="akt-pending-list">
            @foreach($pending as $b)
                <div class="akt-pending-card">
                    <div class="akt-pending-info">
                        <div class="akt-pending-name">{{ $b->user->name ?? '-' }}</div>
                        <div class="akt-pending-meta">
                            {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }} · {{ substr($b->jam, 0, 5) }} · {{ $b->topik }}
                        </div>
                    </div>
                    <div class="akt-pending-badge">Pending</div>
                    <div class="akt-pending-action">
                        <a href="{{ route('dosen.bimbingan') }}" class="akt-btn-balas">Balas</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection