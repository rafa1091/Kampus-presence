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

    .bim-card-inner { display: flex; align-items: flex-start; gap: 0; }

    /* Kolom tanggal */
    .bim-date-col { flex-shrink: 0; width: 90px; padding: 20px 16px; border-right: 0.5px solid #F1F5F9; text-align: center; }
    .bim-date-day  { font-size: 10px; color: #94A3B8; font-weight: 600; margin-bottom: 2px; }
    .bim-date-time { font-size: 20px; font-weight: 800; color: #1E2A4A; line-height: 1; }

    /* Body */
    .bim-card-body { flex: 1; padding: 18px 20px; min-width: 0; }
    .bim-from { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-bottom: 6px; }
    .bim-topik { font-size: 15px; font-weight: 700; color: #1E2A4A; margin-bottom: 4px; }
    .bim-pesan { font-size: 13px; color: #64748B; margin-bottom: 12px; }

    .bim-balasan { border-left: 2px solid #E2E8F0; padding-left: 12px; margin-bottom: 12px; }
    .bim-balasan-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94A3B8; margin-bottom: 4px; }
    .bim-balasan-text  { font-size: 12px; color: #475569; }

    /* Aksi */
    .bim-actions { display: flex; gap: 8px; }
    .bim-btn-approve { padding: 8px 16px; background: #1E2A4A; color: #fff; border: none; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: background .15s; display: flex; align-items: center; gap: 5px; }
    .bim-btn-approve:hover { background: #4F7EF8; }
    .bim-btn-reject  { padding: 8px 16px; background: #FEF2F2; color: #B91C1C; border: 0.5px solid #FECACA; border-radius: 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: all .15s; display: flex; align-items: center; gap: 5px; }
    .bim-btn-reject:hover { background: #EF4444; color: #fff; border-color: #EF4444; }
    .bim-btn-icon { width: 13px; height: 13px; }

    /* Badge */
    .bim-badge-col { flex-shrink: 0; padding: 18px 16px; display: flex; align-items: flex-start; }
    .bim-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 10px; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
    .bim-badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-approved { background: #ECFDF5; color: #059669; }
    .badge-approved .bim-badge-dot { background: #10B981; }
    .badge-pending  { background: #FFFBEB; color: #B45309; }
    .badge-pending .bim-badge-dot  { background: #F59E0B; }
    .badge-rejected { background: #FEF2F2; color: #B91C1C; }
    .badge-rejected .bim-badge-dot { background: #EF4444; }

    /* Empty */
    .bim-empty { background: #fff; border-radius: 16px; padding: 4rem 2rem; text-align: center; border: 0.5px solid rgba(0,0,0,.07); box-shadow: 0 2px 10px rgba(30,42,74,.05); }
    .bim-empty-title { font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 1px; }

    /* Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 60; display: flex; align-items: center; justify-content: center; }
    .modal-box { background: #fff; width: 100%; max-width: 460px; margin: 1rem; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.2); overflow: hidden; }
    .modal-header { padding: 20px 24px 16px; border-bottom: 0.5px solid #F1F5F9; display: flex; justify-content: space-between; align-items: flex-start; }
    .modal-eyebrow { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #8AAEFB; margin-bottom: 4px; }
    .modal-title   { font-size: 20px; font-weight: 800; color: #1E2A4A; }
    .modal-sub     { font-size: 12px; color: #64748B; margin-top: 2px; }
    .modal-close   { width: 28px; height: 28px; border-radius: 50%; border: none; background: #F4F6FB; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748B; flex-shrink: 0; }
    .modal-close:hover { background: #E2E8F0; }
    .modal-close svg { width: 14px; height: 14px; }
    .modal-body    { padding: 20px 24px; }
    .modal-label   { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94A3B8; margin-bottom: 8px; display: block; }
    .modal-textarea { width: 100%; border: 0.5px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; font-size: 13px; font-family: inherit; color: #1E2A4A; resize: none; outline: none; transition: border-color .15s; }
    .modal-textarea:focus { border-color: #4F7EF8; }
    .modal-hint    { font-size: 11px; color: #94A3B8; margin-top: 6px; }
    .modal-footer  { padding: 0 24px 20px; display: flex; gap: 8px; justify-content: flex-end; }
    .modal-btn-cancel  { padding: 9px 18px; background: #F4F6FB; color: #64748B; border: 0.5px solid #E2E8F0; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: all .15s; }
    .modal-btn-cancel:hover { background: #E2E8F0; }
    .modal-btn-submit  { padding: 9px 18px; color: #fff; border: none; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; font-family: inherit; transition: background .15s; }
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
        @if($active === 'SEMUA' || $item->status === $active)
        @php $shown++; @endphp

        @php
            $statusLower = strtolower($item->status);
        @endphp

        <div class="bim-card">
            <div class="bim-card-inner">

                {{-- Tanggal & Jam --}}
                <div class="bim-date-col">
                    <div class="bim-date-day">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M') }}</div>
                    <div class="bim-date-time">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</div>
                </div>

                {{-- Body --}}
                <div class="bim-card-body">
                    <div class="bim-from">
                        DARI · {{ strtoupper($item->mahasiswa ?? ($item->user->name ?? '-')) }}
                        @if($item->nim ?? $item->user->nim ?? null)
                            ({{ $item->nim ?? $item->user->nim }})
                        @endif
                    </div>
                    <div class="bim-topik">{{ $item->topik }}</div>
                    @if($item->pesan ?? $item->catatan ?? null)
                        <div class="bim-pesan">{{ $item->pesan ?? $item->catatan }}</div>
                    @endif

                    @if($item->balasan ?? $item->catatan_dosen ?? null)
                        <div class="bim-balasan">
                            <div class="bim-balasan-label">Balasan Dosen</div>
                            <div class="bim-balasan-text">{{ $item->balasan ?? $item->catatan_dosen }}</div>
                        </div>
                    @endif

                    @if($item->status === 'PENDING' || $item->status === 'pending')
                        <div class="bim-actions">
                            <button onclick="bukaModal('terima', {{ $item->id }}, '{{ addslashes($item->mahasiswa ?? ($item->user->name ?? '')) }}', '{{ addslashes($item->topik) }}')"
                                    class="bim-btn-approve">
                                <svg class="bim-btn-icon" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Terima
                            </button>
                            <button onclick="bukaModal('tolak', {{ $item->id }}, '{{ addslashes($item->mahasiswa ?? ($item->user->name ?? '')) }}', '{{ addslashes($item->topik) }}')"
                                    class="bim-btn-reject">
                                <svg class="bim-btn-icon" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Tolak
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Badge --}}
                <div class="bim-badge-col">
                    <div class="bim-badge badge-{{ $statusLower }}">
                        <div class="bim-badge-dot"></div>
                        {{ ucfirst($statusLower) }}
                    </div>
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
<div id="modal-overlay" class="modal-overlay" style="display:none;" onclick="tutupModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow" id="modal-eyebrow"></div>
                <div class="modal-title" id="modal-title"></div>
                <div class="modal-sub" id="modal-sub"></div>
            </div>
            <button class="modal-close" onclick="tutupModal()">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form id="modal-form" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <label class="modal-label">Balasan untuk Mahasiswa</label>
                <textarea name="balasan" id="modal-balasan" rows="4"
                          placeholder="Tulis balasan atau catatan..." class="modal-textarea" required></textarea>
                <div class="modal-hint">Balasan ini akan dikirimkan ke mahasiswa setelah konfirmasi.</div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModal()" class="modal-btn-cancel">Batal</button>
                <button type="submit" id="modal-submit-btn" class="modal-btn-submit">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function bukaModal(tipe, id, mahasiswa, topik) {
    const overlay   = document.getElementById('modal-overlay');
    const form      = document.getElementById('modal-form');
    const eyebrow   = document.getElementById('modal-eyebrow');
    const title     = document.getElementById('modal-title');
    const sub       = document.getElementById('modal-sub');
    const submitBtn = document.getElementById('modal-submit-btn');
    const textarea  = document.getElementById('modal-balasan');

    const endpoint = tipe === 'terima'
        ? `{{ url('dosen/bimbingan') }}/${id}/approve`
        : `{{ url('dosen/bimbingan') }}/${id}/reject`;

    form.action    = endpoint;
    textarea.value = '';

    if (tipe === 'terima') {
        eyebrow.textContent   = 'Konfirmasi Terima';
        title.textContent     = 'Terima permintaan ini?';
        sub.textContent       = mahasiswa + ' · ' + topik;
        submitBtn.textContent = 'Ya, Terima';
        submitBtn.style.background = '#1E2A4A';
        textarea.placeholder  = 'Contoh: Baik, kita jadwalkan Selasa pukul 10.00 di ruang A201.';
    } else {
        eyebrow.textContent   = 'Konfirmasi Tolak';
        title.textContent     = 'Tolak permintaan ini?';
        sub.textContent       = mahasiswa + ' · ' + topik;
        submitBtn.textContent = 'Ya, Tolak';
        submitBtn.style.background = '#EF4444';
        textarea.placeholder  = 'Contoh: Maaf, jadwal saya penuh. Silakan ajukan ulang minggu depan.';
    }

    overlay.style.display = 'flex';
    setTimeout(() => textarea.focus(), 100);
}

function tutupModal(e) {
    if (e && e.target !== document.getElementById('modal-overlay')) return;
    document.getElementById('modal-overlay').style.display = 'none';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.getElementById('modal-overlay').style.display = 'none';
});
</script>
@endpush

@endsection