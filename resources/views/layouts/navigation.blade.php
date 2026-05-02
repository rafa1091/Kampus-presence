<nav class="sticky top-0 z-50 flex items-center justify-between px-12 h-[60px] bg-white border-b border-gray-200">
    <div class="flex items-center gap-10">
        {{-- Logo --}}
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2.5">
            <svg class="w-7 h-7" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="28" height="28" fill="#0a0a0a"/>
                <path d="M14 7L22 11L14 15L6 11L14 7Z" fill="white"/>
                <path d="M10 13V18C10 18 11.5 20 14 20C16.5 20 18 18 18 18V13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="22" y1="11" x2="22" y2="17" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="text-[15px] font-extrabold tracking-tight">
                KAMPUS<span class="text-gray-400 font-medium">/presence</span>
            </span>
        </a>

        {{-- Nav Links --}}
        <div class="flex">
            <a href="{{ route('mahasiswa.dashboard') }}"
               class="flex items-center gap-1.5 px-3 py-1 text-[11px] font-bold uppercase tracking-wide border-b-2
                      {{ request()->routeIs('mahasiswa.dashboard') ? 'border-black text-black' : 'border-transparent text-gray-400 hover:text-black' }}
                      transition-colors">
                ⊞ Dashboard
            </a>
            <a href="{{ route('mahasiswa.bimbingan') }}"
               class="flex items-center gap-1.5 px-3 py-1 text-[11px] font-bold uppercase tracking-wide border-b-2
                      {{ request()->routeIs('mahasiswa.bimbingan') ? 'border-black text-black' : 'border-transparent text-gray-400 hover:text-black' }}
                      transition-colors">
                ☰ Bimbingan
            </a>
        </div>
    </div>

    {{-- User Info + Logout --}}
    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 leading-none">
                {{ Auth::user()->role ?? 'Mahasiswa' }}
            </p>
            <p class="text-[13px] font-bold mt-0.5">
                {{ Auth::user()->name ?? 'Guest' }}
            </p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-9 h-9 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition-colors"
                    title="Logout">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</nav>