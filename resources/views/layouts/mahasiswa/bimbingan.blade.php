@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10 pb-24">

    <header class="mb-8">
        <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Direktori Dosen</p>
        <div class="flex justify-between items-end">
            <h1 class="text-[32px] font-extrabold leading-tight tracking-tight">Request bimbingan saya</h1>
            <div class="text-[11px] text-gray-400">Total: <span class="font-bold text-black">{{ $bimbingans->count() }}</span> request</div>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-black text-white text-[11px] font-bold uppercase tracking-wide">✓ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-4 py-3 bg-red-500 text-white text-[11px] font-bold uppercase tracking-wide">{{ session('error') }}</div>
    @endif

    <div class="flex gap-0 mb-7 border border-gray-200 w-fit">
        @foreach (['semua' => 'Semua', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
            <a href="{{ route('mahasiswa.bimbingan', ['status' => $key]) }}"
               class="h-9 px-4 text-[9px] font-bold uppercase tracking-wide flex items-center
                      {{ $status === $key ? 'bg-black text-white' : 'text-gray-500 hover:bg-gray-100' }}
                      {{ !$loop->first ? 'border-l border-gray-200' : '' }} transition-colors">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($bimbingans->isEmpty())
        <div class="border border-gray-200 py-20 text-center">
            <p class="text-[12px] text-gray-400 font-bold uppercase tracking-widest">Belum ada request bimbingan</p>
            <p class="text-[11px] text-gray-300 mt-2">Klik "Request Bimbingan" di halaman Dashboard</p>
        </div>
    @else
        <div class="flex flex-col gap-3">
            @foreach ($bimbingans as $item)
            <div class="bg-white border border-gray-200 p-5 hover:border-gray-400 transition-all">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        @php
                            $badgeConfig = [
                                'pending'  => ['dot' => 'bg-yellow-400', 'label' => 'Pending'],
                                'approved' => ['dot' => 'bg-green-500',  'label' => 'Approved'],
                                'rejected' => ['dot' => 'bg-red-500',    'label' => 'Rejected'],
                            ];
                            $badge = $badgeConfig[$item->status];
                        @endphp
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 border border-gray-200 text-[8px] font-bold uppercase tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }} shrink-0"></span>{{ $badge['label'] }}
                            </span>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wide">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[8px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dosen</p>
                        <p class="text-[16px] font-extrabold tracking-tight mb-1">{{ $item->dosen->nama ?? '-' }}</p>
                        <p class="text-[13px] text-gray-600 mb-3">{{ $item->topik }}</p>
                        <div class="flex items-center gap-4 text-[10px] text-gray-500">
                            <span>📅 {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                            <span>🕐 {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB</span>
                        </div>
                        @if ($item->catatan)
                            <p class="text-[10px] text-gray-400 italic mt-2 border-l-2 border-gray-200 pl-2">"{{ $item->catatan }}"</p>
                        @endif
                        @if ($item->catatan_dosen)
                            <div class="mt-3 p-3 {{ $item->status === 'approved' ? 'bg-green-50 border border-green-100' : 'bg-red-50 border border-red-100' }}">
                                <p class="text-[9px] font-bold uppercase tracking-wide {{ $item->status === 'approved' ? 'text-green-600' : 'text-red-500' }} mb-1">Catatan Dosen</p>
                                <p class="text-[11px] text-gray-600">{{ $item->catatan_dosen }}</p>
                            </div>
                        @endif
                    </div>
                    @if ($item->status === 'pending')
                        <form method="POST" action="{{ route('mahasiswa.bimbingan.destroy', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Batalkan request ini?')"
                                    class="h-8 px-3 text-[9px] font-bold uppercase tracking-wide border border-gray-200 text-gray-400 hover:border-red-300 hover:text-red-500 transition-colors">
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