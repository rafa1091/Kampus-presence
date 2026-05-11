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
                    <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
                          style="background:#fff3e0; color:#ea6500; border:1px solid #fbcda0;">
                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                        {{ strtoupper($dosen->status_label ?? 'SEDANG MENGAJAR') }}
                    </span>
                </div>

                <h2 class="text-3xl font-extrabold mt-2 mb-1">Halo, {{ $dosen->nama ?? Auth::user()->name }}</h2>
                <p class="text-sm text-gray-400 mb-6">Perbarui status agar mahasiswa tahu keberadaan Anda.</p>

                {{-- Pilihan Status --}}
                <form action="{{ route('dosen.status.update') }}" method="POST" id="formStatus">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

                        {{-- Di Ruangan --}}
                        <div id="card-di_ruangan"
                             onclick="pilihStatus('di_ruangan', this)"
                             class="rounded-xl p-4 text-center cursor-pointer transition-all duration-200 border
                                    {{ ($dosen->status ?? '') === 'di_ruangan' ? 'bg-gray-900 border-gray-900 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-gray-400' }}">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 block mx-auto mb-2"></span>
                            <span class="text-sm font-medium">Di Ruangan</span>
                        </div>

                        {{-- Sedang Mengajar --}}
                        <div id="card-sedang_mengajar"
                             onclick="pilihStatus('sedang_mengajar', this)"
                             class="rounded-xl p-4 text-center cursor-pointer transition-all duration-200 border
                                    {{ ($dosen->status ?? '') === 'sedang_mengajar' ? 'bg-gray-900 border-gray-900 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-gray-400' }}">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-400 block mx-auto mb-2"></span>
                            <span class="text-sm font-medium">Sedang Mengajar</span>
                        </div>

                        {{-- Sedang Bimbingan --}}
                        <div id="card-sedang_bimbingan"
                             onclick="pilihStatus('sedang_bimbingan', this)"
                             class="rounded-xl p-4 text-center cursor-pointer transition-all duration-200 border
                                    {{ ($dosen->status ?? '') === 'sedang_bimbingan' ? 'bg-gray-900 border-gray-900 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-gray-400' }}">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 block mx-auto mb-2"></span>
                            <span class="text-sm font-medium">Sedang Bimbingan</span>
                        </div>

                        {{-- Tidak Ada --}}
                        <div id="card-tidak_ada"
                             onclick="pilihStatus('tidak_ada', this)"
                             class="rounded-xl p-4 text-center cursor-pointer transition-all duration-200 border
                                    {{ ($dosen->status ?? '') === 'tidak_ada' ? 'bg-gray-900 border-gray-900 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-gray-400' }}">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 block mx-auto mb-2"></span>
                            <span class="text-sm font-medium">Tidak Ada</span>
                        </div>
                    </div>

                    <input type="hidden" name="status" id="inputStatus" value="{{ $dosen->status ?? '' }}">

                    {{-- Catatan Status --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            CATATAN STATUS (OPSIONAL)
                        </label>
                        <textarea name="catatan"
                                  rows="5"
                                  placeholder="Masukkan Catatan..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 placeholder-gray-300 resize-none focus:outline-none focus:border-gray-400 transition-colors">{{ $dosen->catatan_status ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-gray-900 text-white text-[11px] font-bold uppercase tracking-widest px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
                            SIMPAN STATUS
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ===================== KOLOM KANAN: PROFIL & STATISTIK ===================== --}}
        <div class="w-72 shrink-0">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 h-full">

                <form action="{{ route('dosen.profil.update') }}" method="POST" enctype="multipart/form-data">
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
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-gray-400 transition-colors">
                        @error('ruangan')
                            <small class="text-red-500 text-xs mt-1 block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- No. HP --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            NO.HP
                        </label>
                        <input type="text"
                               name="no_hp"
                               value="{{ $dosen->no_hp ?? '' }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-gray-400 transition-colors">
                        @error('no_hp')
                            <small class="text-red-500 text-xs mt-1 block">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Foto Profil --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">
                            FOTO PROFIL
                        </label>

                        @if($dosen->foto_profil ?? null)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $dosen->foto_profil) }}"
                                     alt="Foto Profil"
                                     class="w-full h-20 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <input type="file"
                               name="foto_profil"
                               accept="image/*"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-700">
                        @error('foto_profil')
                            <small class="text-red-500 text-xs mt-1 block">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-gray-900 text-white text-[11px] font-bold uppercase tracking-widest py-2.5 rounded-lg hover:bg-gray-700 transition-colors">
                        SIMPAN PROFIL
                    </button>
                </form>

                {{-- Divider --}}
                <hr class="my-5 border-gray-100">

                {{-- Statistik Bimbingan --}}
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">
                        STATISTIK BIMBINGAN
                    </p>

                    <div class="flex text-center">
                        <div class="flex-1">
                            <div class="text-2xl font-bold">{{ $statistik['pending'] ?? 0 }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-gray-400 mt-0.5">PENDING</div>
                        </div>
                        <div class="flex-1 border-l border-gray-100">
                            <div class="text-2xl font-bold">{{ $statistik['diterima'] ?? 0 }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-gray-400 mt-0.5">DITERIMA</div>
                        </div>
                        <div class="flex-1 border-l border-gray-100">
                            <div class="text-2xl font-bold">{{ $statistik['total'] ?? 0 }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-gray-400 mt-0.5">TOTAL</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function pilihStatus(status, el) {
        const statuses = ['di_ruangan', 'sedang_mengajar', 'sedang_bimbingan', 'tidak_ada'];
        statuses.forEach(s => {
            const card = document.getElementById('card-' + s);
            card.classList.remove('bg-gray-900', 'border-gray-900', 'text-white');
            card.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
        });

        el.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
        el.classList.add('bg-gray-900', 'border-gray-900', 'text-white');

        document.getElementById('inputStatus').value = status;
        document.getElementById('formStatus').submit();
    }

    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(el => el.remove());
    }, 3500);
</script>
@endpush