@extends('layouts.app')

@section('title', 'Jadwal Saya')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10">

    {{-- Header --}}
    <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 mb-1">Jadwal Mingguan</p>
        <h1 class="text-[28px] font-extrabold tracking-tight leading-none text-[#0a0a0a]">Atur Jadwal Anda</h1>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[13px] text-green-700 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Jadwal - Simpel & Pasti Muncul --}}
    <div class="bg-white border border-gray-300 rounded-lg p-5 mb-8">
        <form action="{{ route('dosen.jadwal.store') }}" method="POST" class="flex flex-row items-end gap-4 flex-wrap lg:flex-nowrap w-full">
            @csrf

            {{-- Hari --}}
            <div class="flex-1 min-w-[120px]">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Hari</label>
                <select name="hari"
                    class="w-full appearance-none border border-gray-300 rounded-lg px-3 py-2 text-[13px] text-[#0a0a0a] outline-none bg-white cursor-pointer transition-colors">
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                    <option value="{{ $hari }}" {{ old('hari') === $hari ? 'selected' : '' }}>{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Mulai --}}
            <div class="w-[110px]">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Mulai</label>
                <input type="time" name="mulai" value="{{ old('mulai') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[13px] text-[#0a0a0a] outline-none transition-colors">
            </div>

            {{-- Selesai --}}
            <div class="w-[110px]">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Selesai</label>
                <input type="time" name="selesai" value="{{ old('selesai') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[13px] text-[#0a0a0a] outline-none transition-colors">
            </div>

            {{-- Aktifitas --}}
            <div class="flex-1 min-w-[140px]">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Aktifitas</label>
                <select name="aktifitas"
                    class="w-full appearance-none border border-gray-300 rounded-lg px-3 py-2 text-[13px] text-[#0a0a0a] outline-none bg-white cursor-pointer transition-colors">
                    <option value="Mengajar">Mengajar</option>
                    <option value="Bimbingan">Bimbingan</option>
                    <option value="Rapat">Rapat</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            {{-- Matakuliah --}}
            <div class="flex-[1.5] min-w-[180px]">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Matakuliah (Opsional)</label>
                <input type="text" name="matakuliah" value="{{ old('matakuliah') }}" placeholder="Contoh: Pemrograman"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-[13px] text-[#0a0a0a] outline-none placeholder-gray-300 transition-colors">
            </div>

            {{-- Tombol Tambah Simpel (Sejajar Inputan) --}}
            <div class="shrink-0">
                <button class="w-full h-[38px] px-6 bg-white border-2 border-black text-black font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all">
                    SIMPAN PERUBAHAN
                </button>
            </div>
            
        </form>
    </div>

    {{-- Pemrosesan Data Asli dari DB --}}
    @php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jadwalPerHari = [];
        
        // Kita pastikan variabel $jadwal dibungkus collect dengan aman
        $collectionJadwal = collect($jadwal ?? []);

        foreach ($hariList as $h) {
            $jadwalPerHari[$h] = $collectionJadwal->filter(function($item) use ($h) {
                $hariData = is_object($item) ? ($item->hari ?? '') : ($item['hari'] ?? '');
                // trim dan strtolower untuk menghindari spasi tak terlihat yang bikin gagal COCOK
                return strtolower(trim($hariData)) === strtolower(trim($h));
            })->values();
        }
    @endphp

    {{-- Jadwal Mingguan - Struktur Baris Horizontal --}}
    <div class="flex flex-col gap-3">
        @foreach($hariList as $hari)
        
        {{-- Satu Baris untuk Satu Hari --}}
        <div class="flex bg-white border border-gray-300 min-h-[90px] rounded-lg overflow-hidden">
            
            {{-- Kolom Kiri: Nama Hari --}}
            <div class="w-[120px] bg-gray-50 border-r border-gray-300 flex items-center justify-center shrink-0 p-4">
                <p class="text-[12px] font-bold uppercase tracking-wider text-gray-700 text-center w-full">
                    {{ $hari }}
                </p>
            </div>

            {{-- Kolom Kanan: Daftar Card Jadwal Mengalir ke Kanan --}}
            <div class="flex-1 flex flex-row items-center gap-3 p-3 overflow-x-auto whitespace-nowrap scrollbar-thin">
                @forelse($jadwalPerHari[$hari] as $j)
                @php
                    $id = is_object($j) ? $j->id : $j['id'];
                    $mulai = is_object($j) ? $j->mulai : $j['mulai'];
                    $selesai = is_object($j) ? $j->selesai : $j['selesai'];
                    
                    // SINKRONISASI TOTAL: Mengambil dari nama kolom database asli ('aktivitas' pakai V)
                    $namaAktivitas = is_object($j) ? $j->aktivitas : $j['aktivitas']; 
                    
                    $matakuliah = is_object($j) ? $j->matakuliah : $j['matakuliah'];
                @endphp
                
                {{-- Card Jadwal --}}
                <div class="inline-flex bg-gray-100 rounded-lg p-3 min-w-[200px] max-w-[240px] flex-col justify-between shrink-0 border border-gray-200">
                    <div>
                        <p class="text-[12px] font-bold text-[#0a0a0a]">
                            {{ substr($mulai, 0, 5) }} - {{ substr($selesai, 0, 5) }}
                        </p>
                        {{-- DI SINI SUDAH FIXED: Memanggil variabel $namaAktivitas yang bernilai kolom database ber-huruf V --}}
                        <p class="text-[11px] font-semibold text-[#0a0a0a] mt-0.5 truncate">{{ $namaAktivitas }}</p>
                        
                        @if(!empty($matakuliah))
                        <p class="text-[10px] text-gray-500 font-medium italic truncate mt-0.5" title="{{ $matakuliah }}">
                            ({{ $matakuliah }})
                        </p>
                        @endif
                    </div>

                    {{-- Tombol Hapus Form Inline --}}
                    <form action="{{ route('dosen.jadwal.destroy', $id) }}" method="POST" class="mt-2 pt-1.5 border-t border-gray-200 flex justify-end">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Hapus jadwal ini?')"
                            class="flex items-center gap-1 text-[9px] font-bold text-red-600 hover:text-red-800 transition-colors uppercase tracking-wider">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
                @empty
                {{-- Jika tidak ada aktivitas --}}
                <div class="flex items-center h-full px-2">
                    <p class="text-[11px] text-gray-400 italic">Tidak ada jadwal</p>
                </div>
                @endforelse
            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection