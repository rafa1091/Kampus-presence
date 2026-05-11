@extends('layouts.app')

@section('title', 'Bimbingan')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10">

    {{-- Header --}}
    <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 mb-1">Dosen</p>
        <h1 class="text-[28px] font-extrabold tracking-tight leading-none">Request dari mahasiswa</h1>
    </div>

    {{-- Filter Tabs --}}
    @php $active = request('filter', 'SEMUA'); @endphp
    <div class="flex gap-2 mb-6">
        @foreach(['SEMUA','PENDING','APPROVED','REJECTED'] as $f)
        <a href="?filter={{ $f }}"
           class="px-4 py-2 text-[11px] font-bold uppercase tracking-widest border transition-colors
                  {{ $active === $f ? 'bg-[#0a0a0a] text-white border-[#0a0a0a]' : 'bg-white text-[#0a0a0a] border-gray-300 hover:border-gray-500' }}">
            {{ $f }}
        </a>
        @endforeach
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[13px] text-green-700 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- List Bimbingan --}}
    <div class="flex flex-col gap-3">
        @forelse($requests as $item)
        @if($active === 'SEMUA' || $item->status === $active)

        <div class="bg-white border border-gray-200 rounded-xl p-6 flex gap-6 items-start">

            {{-- Tanggal & Jam --}}
            <div class="w-20 flex-shrink-0">
                <p class="text-[10px] text-gray-400 font-medium">{{ $item->tanggal }}</p>
                <p class="text-[22px] font-extrabold tracking-tight leading-none mt-0.5">{{ $item->jam }}</p>
            </div>

            {{-- Info Utama --}}
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">
                    DARI · {{ strtoupper($item->mahasiswa) }} ({{ $item->nim }})
                </p>
                <p class="text-[14px] font-semibold text-[#0a0a0a] mb-1">{{ $item->topik }}</p>
                <p class="text-[13px] text-gray-500 mb-3">{{ $item->pesan }}</p>

                @if($item->balasan)
                <div class="border-l-2 border-gray-300 pl-4 mb-3">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Balasan Dosen</p>
                    <p class="text-[13px] text-gray-600">{{ $item->balasan }}</p>
                </div>
                @endif

                {{-- Tombol aksi — hanya jika PENDING --}}
                @if($item->status === 'PENDING')
                <div class="flex gap-2 mt-3">
                    <button
                        onclick="bukaModal('terima', {{ $item->id }}, '{{ addslashes($item->mahasiswa) }}', '{{ addslashes($item->topik) }}')"
                        class="px-5 py-2 bg-[#0a0a0a] text-white text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-gray-800 transition-colors">
                        ✓ Terima
                    </button>
                    <button
                        onclick="bukaModal('tolak', {{ $item->id }}, '{{ addslashes($item->mahasiswa) }}', '{{ addslashes($item->topik) }}')"
                        class="px-5 py-2 bg-white text-red-600 border border-red-300 text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-red-50 transition-colors">
                        ✕ Tolak
                    </button>
                </div>
                @endif
            </div>

            {{-- Badge Status --}}
            <div class="flex-shrink-0">
                @php
                    $badgeMap = [
                        'APPROVED' => 'bg-green-50 border-green-300 text-green-700',
                        'PENDING'  => 'bg-orange-50 border-orange-300 text-orange-600',
                        'REJECTED' => 'bg-red-50 border-red-300 text-red-600',
                    ];
                    $dotMap = [
                        'APPROVED' => 'bg-green-500',
                        'PENDING'  => 'bg-orange-500',
                        'REJECTED' => 'bg-red-500',
                    ];
                @endphp
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-[10px] font-bold uppercase tracking-widest {{ $badgeMap[$item->status] ?? '' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $dotMap[$item->status] ?? '' }}"></span>
                    {{ $item->status }}
                </span>
            </div>
        </div>

        @endif
        @empty
        <div class="bg-white border border-gray-200 rounded-xl px-6 py-12 text-center">
            <p class="text-[13px] text-gray-400">Belum ada permintaan bimbingan.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ══════════════ MODAL POPUP ══════════════ --}}
<div id="modal-overlay"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center"
     onclick="tutupModal(event)">

    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl" onclick="event.stopPropagation()">

        {{-- Modal Header --}}
        <div class="px-6 pt-6 pb-4 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p id="modal-eyebrow" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1"></p>
                    <h2 id="modal-title" class="text-[18px] font-extrabold tracking-tight"></h2>
                    <p id="modal-sub" class="text-[12px] text-gray-400 mt-1"></p>
                </div>
                <button onclick="tutupModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors ml-4 mt-0.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body: Form Balasan --}}
        <form id="modal-form" method="POST">
            @csrf
            @method('PATCH')

            <div class="px-6 py-5">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                    Balasan untuk Mahasiswa
                </label>
                <textarea
                    name="balasan"
                    id="modal-balasan"
                    rows="4"
                    placeholder="Tulis balasan atau catatan untuk mahasiswa..."
                    class="w-full border-[1.5px] border-gray-200 rounded-xl px-4 py-3 text-[13px] text-[#0a0a0a] resize-none outline-none transition-colors focus:border-gray-500 placeholder-gray-300"
                    required></textarea>
                <p class="text-[11px] text-gray-400 mt-2">Balasan ini akan dikirimkan ke mahasiswa setelah kamu konfirmasi.</p>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 pb-6 flex gap-2 justify-end">
                <button type="button" onclick="tutupModal()"
                    class="px-5 py-2.5 bg-white text-[#0a0a0a] border border-gray-200 text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" id="modal-submit-btn"
                    class="px-5 py-2.5 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ROUTE_APPROVE = '{{ url("dosen/bimbingan") }}';
    const ROUTE_REJECT  = '{{ url("dosen/bimbingan") }}';

    function bukaModal(tipe, id, mahasiswa, topik) {
        const overlay   = document.getElementById('modal-overlay');
        const form      = document.getElementById('modal-form');
        const eyebrow   = document.getElementById('modal-eyebrow');
        const title     = document.getElementById('modal-title');
        const sub       = document.getElementById('modal-sub');
        const submitBtn = document.getElementById('modal-submit-btn');
        const textarea  = document.getElementById('modal-balasan');

        // Set action form
        const endpoint = tipe === 'terima'
            ? `{{ url('dosen/bimbingan') }}/${id}/approve`
            : `{{ url('dosen/bimbingan') }}/${id}/reject`;

        form.action = endpoint;
        textarea.value = '';

        if (tipe === 'terima') {
            eyebrow.textContent   = 'Konfirmasi Terima';
            title.textContent     = 'Terima permintaan ini?';
            sub.textContent       = `${mahasiswa} · ${topik}`;
            submitBtn.textContent = '✓ Ya, Terima';
            submitBtn.className   = 'px-5 py-2.5 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors bg-[#0a0a0a] hover:bg-gray-800';
            textarea.placeholder  = 'Contoh: Baik, kita jadwalkan Selasa pukul 10.00 di ruang A201.';
        } else {
            eyebrow.textContent   = 'Konfirmasi Tolak';
            title.textContent     = 'Tolak permintaan ini?';
            sub.textContent       = `${mahasiswa} · ${topik}`;
            submitBtn.textContent = '✕ Ya, Tolak';
            submitBtn.className   = 'px-5 py-2.5 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors bg-red-600 hover:bg-red-700';
            textarea.placeholder  = 'Contoh: Maaf, jadwal saya penuh. Silakan ajukan ulang minggu depan.';
        }

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        setTimeout(() => textarea.focus(), 100);
    }

    function tutupModal(e) {
        if (e && e.target !== document.getElementById('modal-overlay')) return;
        const overlay = document.getElementById('modal-overlay');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }

    // Tutup dengan ESC
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.getElementById('modal-overlay').classList.add('hidden');
            document.getElementById('modal-overlay').classList.remove('flex');
        }
    });
</script>
@endpush