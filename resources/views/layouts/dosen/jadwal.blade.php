@extends('layouts.app')

@section('title', 'Jadwal Saya')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10">

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