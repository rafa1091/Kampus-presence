@extends('layouts.app')

@section('title', 'Bimbingan')

@section('content')

<style>
    *, *::before, *::after { box-sizing: border-box; }

    .bim-hero { background: linear-gradient(135deg, #1E2A4A 0%, #2D3F6B 100%); padding: 2rem 2rem 3.5rem; }
    .bim-hero-inner { max-width: 960px; margin: 0 auto; }
    .bim-hero-label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #8AAEFB; text-transform: uppercase; margin-bottom: 0.4rem; }
    .bim-hero-title { font-size: 26px; font-weight: 700; color: #fff; line-height: 1.3; }

    .bim-main { max-width: 960px; margin: -1.5rem auto 4rem; padding: 0 2rem; position: relative; z-index: 1; }

    /* Alert */
    .bim-alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .bim-alert-success { background: #ECFDF5; color: #059669; border: 0.5px solid #A7F3D0; }

    /* Tabs */
    .bim-tabs { background: #fff; border-radius: 14px; padding: 8px; display: flex; gap: 6px; margin-bottom: 1.5rem; border: 0.5px solid rgba(0,0,0,.08); box-shadow: 0 2px 12px rgba(30,42,74,.06); width: fit-content; }
    .bim-tab { font-size: 11px; font-weight: 700; padding: 7px 16px; border-radius: 8px; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; color: #64748B; transition: all .15s; }
    .bim-tab:hover { background: #F4F6FB; color: #1E2A4A; }
    .bim-tab.active { background: #1E2A4A; color: #fff; }

    /* List */
    .bim-list { display: flex; flex-direction: column; gap: 12px; }

    /* Card */
    .bim-card { background: #fff; border-radius: 16px; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 2px 10px rgba(30,42,74,.05); overflow: hidden; transition: box-shadow .2s; }
    .bim-card:hover { box-shadow: 0 6px 20px rgba(30,42,74,.08); }
    .bim-card-inner { display: flex; align-items: flex-start; }

    /* Kolom tanggal */
    .bim-date-col { flex-shrink: 0; width: 90px; padding: 20px 16px; border-right: 0.5px solid #F1F5F9; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .bim-date-day  { font-size: 10px; color: #94A3B8; font-weight: 600; margin-bottom: 2px; }
    .bim-date-num  { font-size: 22px; font-weight: 800; color: #1E2A4A; line-height: 1; }
    .bim-date-time { font-size: 11px; color: #94A3B8; font-weight: 600; margin-top: 4px; }

    /* Body */
    .bim-card-body { flex: 1; padding: 18px 20px; min-width: 0; }
    .bim-from  { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-bottom: 4px; }
    .bim-topik { font-size: 15px; font-weight: 700; color: #1E2A4A; margin-bottom: 6px; }
    .bim-pesan { font-size: 13px; color: #64748B; margin-bottom: 12px; line-height: 1.5; }

    .bim-balasan { border-left: 2px solid #E2E8F0; padding-left: 12px; margin-bottom: 12px; }
    .bim-balasan-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-bottom: 4px; }
    .bim-balasan-text  { font-size: 12px; color: #475569; }

    /* Aksi */
    .bim-actions { display: flex; gap: 8px; margin-top: 4px; }
    .bim-btn-approve { padding: 8px 16px; background: #1E2A4A; color: #fff; border: none; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: background .15s; }
    .bim-btn-approve:hover { background: #4F7EF8; }
    .bim-btn-reject  { padding: 8px 16px; background: #FEF2F2; color: #B91C1C; border: 0.5px solid #FECACA; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: all .15s; }
    .bim-btn-reject:hover { background: #EF4444; color: #fff; border-color: #EF4444; }

    /* Badge kolom kanan */
    .bim-badge-col { flex-shrink: 0; padding: 18px 16px; display: flex; align-items: flex-start; }
    .bim-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 10px; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
    .bim-badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-approved { background: #ECFDF5; color: #059669; }
    .badge-approved .bim-badge-dot { background: #10B981; }
    .badge-pending  { background: #FFFBEB; color: #B45309; }
    .badge-pending  .bim-badge-dot { background: #F59E0B; }
    .badge-rejected { background: #FEF2F2; color: #B91C1C; }
    .badge-rejected .bim-badge-dot { background: #EF4444; }

    /* Empty */
    .bim-empty { background: #fff; border-radius: 16px; padding: 4rem 2rem; text-align: center; border: 0.5px solid rgba(0,0,0,.07); }
    .bim-empty-title { font-size: 13px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; }

    /* Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 60; display: none; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: #fff; width: 100%; max-width: 460px; margin: 1rem; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.2); overflow: hidden; }
    .modal-header { padding: 20px 24px 16px; border-bottom: 0.5px solid #F1F5F9; display: flex; justify-content: space-between; align-items: flex-start; }
    .modal-eyebrow { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #8AAEFB; margin-bottom: 4px; }
    .modal-title   { font-size: 20px; font-weight: 800; color: #1E2A4A; }
    .modal-close   { width: 28px; height: 28px; border-radius: 50%; border: none; background: #F4F6FB; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748B; flex-shrink: 0; }
    .modal-close:hover { background: #E2E8F0; }
    .modal-close svg { width: 14px; height: 14px; }
    .modal-body    { padding: 20px 24px; }
    .modal-label   { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 8px; display: block; }
    .modal-textarea { width: 100%; border: 0.5px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; font-size: 13px; font-family: inherit; color: #1E2A4A; resize: none; outline: none; transition: border-color .15s; }
    .modal-textarea:focus { border-color: #4F7EF8; }
    .modal-footer  { padding: 0 24px 20px; display: flex; gap: 8px; justify-content: flex-end; }
    .modal-btn-cancel { padding: 9px 18px; background: #F4F6FB; color: #64748B; border: 0.5px solid #E2E8F0; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; cursor: pointer; font-family: inherit; }
    .modal-btn-cancel:hover { background: #E2E8F0; }
    .modal-btn-submit { padding: 9px 18px; color: #fff; border: none; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; cursor: pointer; font-family: inherit; }
    .modal-btn-submit.approve { background: #1E2A4A; }
    .modal-btn-submit.approve:hover { background: #4F7EF8; }
    .modal-btn-submit.reject  { background: #EF4444; }
    .modal-btn-submit.reject:hover  { background: #B91C1C; }
</style>

{{-- HERO --}}
<div class="bim-hero">
    <div class="bim-hero-inner">
        <div class="bim-hero-label">Dosen</div>
        <div class="bim-hero-title">Request dari Mahasiswa</div>
    </div>
</div>

{{-- MAIN --}}
<div class="bim-main">

    @if(session('success'))
        <div class="bim-alert bim-alert-success">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Tabs --}}
    @php $active = request('filter', 'SEMUA'); @endphp
    <div class="bim-tabs">
        @foreach(['SEMUA','PENDING','APPROVED','REJECTED'] as $f)
            <a href="?filter={{ $f }}" class="bim-tab {{ $active === $f ? 'active' : '' }}">{{ $f }}</a>
        @endforeach
    </div>

    {{-- List --}}
    <div class="bim-list">
        @php $shown = 0; @endphp

        @forelse($requests as $item)
            @if($active === 'SEMUA' || strtoupper($item->status) === $active)
                @php
                    $shown++;
                    $statusLower = strtolower($item->status);
                    $tgl = \Carbon\Carbon::parse($item->tanggal);
                @endphp

                <div class="bim-card">
                    <div class="bim-card-inner">

                        {{-- Kolom Tanggal --}}
                        <div class="bim-date-col">
                            <div class="bim-date-day">{{ $tgl->translatedFormat('D') }}</div>
                            <div class="bim-date-num">{{ $tgl->format('d') }}</div>
                            <div class="bim-date-time">{{ $tgl->format('M') }}</div>
                            @if($item->jam)
                                <div class="bim-date-time" style="margin-top:6px;">{{ substr($item->jam,0,5) }}</div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="bim-card-body">
                            <div class="bim-from">Dari: {{ $item->user->name ?? '-' }}</div>
                            <div class="bim-topik">{{ $item->topik }}</div>

                            @if($item->catatan)
                                <div class="bim-pesan">{{ $item->catatan }}</div>
                            @endif

                            @if($item->catatan_dosen)
                                <div class="bim-balasan">
                                    <div class="bim-balasan-label">Balasan Anda</div>
                                    <div class="bim-balasan-text">{{ $item->catatan_dosen }}</div>
                                </div>
                            @endif

                            @if($statusLower === 'pending')
                                <div class="bim-actions">
                                    <button class="bim-btn-approve" onclick="openModal('{{ route('dosen.bimbingan.approve', $item->id) }}', 'approve')">
                                        ✓ Setujui
                                    </button>
                                    <button class="bim-btn-reject" onclick="openModal('{{ route('dosen.bimbingan.reject', $item->id) }}', 'reject')">
                                        ✕ Tolak
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Badge Status --}}
                        <div class="bim-badge-col">
                            <span class="bim-badge badge-{{ $statusLower }}">
                                <span class="bim-badge-dot"></span>
                                {{ strtoupper($item->status) }}
                            </span>
                        </div>

                    </div>
                </div>
            @endif
        @empty
        @endforelse

        @if($shown === 0)
            <div class="bim-empty">
                <div class="bim-empty-title">Belum ada permintaan bimbingan</div>
            </div>
        @endif
    </div>

</div>

{{-- MODAL --}}
<div id="modal-overlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow">Konfirmasi</div>
                <div class="modal-title" id="modal-title">Setujui Permintaan</div>
            </div>
            <button class="modal-close" onclick="closeModal()">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="modal-form" method="POST">
            @csrf
            <div class="modal-body">
                <label class="modal-label">Balasan untuk Mahasiswa</label>
                <textarea name="balasan" id="modal-balasan" class="modal-textarea" rows="4" placeholder="Tulis balasan..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" id="modal-submit" class="modal-btn-submit approve">Kirim</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(action, type) {
    document.getElementById('modal-form').action = action;
    const isApprove = type === 'approve';
    document.getElementById('modal-title').innerText = isApprove ? 'Setujui Permintaan' : 'Tolak Permintaan';
    const btn = document.getElementById('modal-submit');
    btn.innerText = isApprove ? 'Setujui' : 'Tolak';
    btn.className = 'modal-btn-submit ' + type;
    document.getElementById('modal-balasan').required = !isApprove;
    document.getElementById('modal-overlay').classList.add('open');
}
function closeModal() {
    document.getElementById('modal-overlay').classList.remove('open');
}
</script>

@endsection