<style>
    .kp-nav {
        background: #1E2A4A;
        padding: 0 2rem;
        display: flex; align-items: center; justify-content: space-between;
        height: 56px; position: sticky; top: 0; z-index: 100;
    }
    .kp-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .kp-logo-icon { width: 32px; height: 32px; background: #4F7EF8; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .kp-logo-icon svg { width: 16px; height: 16px; color: #fff; }
    .kp-logo-text { color: #fff; font-size: 15px; font-weight: 700; letter-spacing: 0.3px; }
    .kp-logo-text span { color: #8AAEFB; font-weight: 400; }
    .kp-nav-links { display: flex; }
    .kp-nav-link { color: #8A9BBF; font-size: 13px; padding: 0 16px; height: 56px; display: flex; align-items: center; gap: 6px; text-decoration: none; border-bottom: 2px solid transparent; transition: color .2s, border-color .2s; }
    .kp-nav-link:hover { color: #C8D4F0; }
    .kp-nav-link.active { color: #fff; border-bottom-color: #4F7EF8; }
    .kp-nav-link svg { width: 15px; height: 15px; }
    .kp-user { display: flex; align-items: center; gap: 10px; }
    .kp-user-info { text-align: right; }
    .kp-user-label { font-size: 10px; color: #5A6A8A; letter-spacing: 0.5px; text-transform: uppercase; }
    .kp-user-name  { font-size: 13px; color: #C8D4F0; font-weight: 600; }
    .kp-avatar-sm { width: 32px; height: 32px; border-radius: 50%; background: #4F7EF8; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 700; }
    .kp-logout { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,.07); border: 0.5px solid rgba(255,255,255,.12); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; }
    .kp-logout:hover { background: rgba(239,68,68,.2); border-color: rgba(239,68,68,.3); }
    .kp-logout svg { width: 15px; height: 15px; color: #8A9BBF; }
    .kp-logout:hover svg { color: #FCA5A5; }
</style>

<nav class="kp-nav">
{{-- Logo --}}
<a href="{{ Auth::user()->role === 'dosen' ? route('dosen.dashboard') : route('mahasiswa.dashboard') }}"
    class="kp-logo flex items-center gap-1">
 
     <svg class="logo-svg" width="40" height="40" viewBox="0 0 40 40" fill="none"
         xmlns="http://www.w3.org/2000/svg">
         <circle cx="20" cy="20" r="18" fill="rgba(255,255,255,0.15)"
             stroke="rgba(255,255,255,0.3)" stroke-width="1" />
         <path d="M20 8 L32 12.5 L32 19.5 Q32 27 20 31 Q8 27 8 19.5 L8 12.5 Z"
             fill="none" stroke="white" stroke-width="1.6" />
         <circle cx="20" cy="17" r="4" fill="none" stroke="#e8c97a"
             stroke-width="1.6" />
         <path d="M12 28 Q12 23 20 23 Q28 23 28 28" fill="none"
             stroke="#e8c97a" stroke-width="1.6" stroke-linecap="round" />
     </svg>
 
     <span class="kp-logo-text">
         KAMPUS<span>/presence</span>
     </span>
 </a>

    {{-- Nav Links --}}
    <div class="kp-nav-links">
        @if(Auth::user()->role === 'dosen')
            <a href="{{ route('dosen.dashboard') }}" class="kp-nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('dosen.bimbingan') }}" class="kp-nav-link {{ request()->routeIs('dosen.bimbingan') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
                Bimbingan
            </a>
            <a href="{{ route('dosen.jadwal') }}" class="kp-nav-link {{ request()->routeIs('dosen.jadwal') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Jadwal Saya
            </a>
        @else
            <a href="{{ route('mahasiswa.dashboard') }}" class="kp-nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('mahasiswa.bimbingan') }}" class="kp-nav-link {{ request()->routeIs('mahasiswa.bimbingan*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
                Bimbingan
            </a>
        @endif
    </div>

    {{-- User + Logout --}}
    <div class="kp-user">
        <div class="kp-user-info">
            <div class="kp-user-label">{{ Auth::user()->role === 'dosen' ? 'Dosen' : 'Mahasiswa' }}</div>
            <div class="kp-user-name">{{ Auth::user()->name ?? 'Guest' }}</div>
        </div>
        <div class="kp-avatar-sm">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="kp-logout" title="Logout">
                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</nav>