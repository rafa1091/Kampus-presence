<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMPUS/presence — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --black: #0a0a0a; --white: #ffffff;
            --gray-200: #e8e8e8; --gray-400: #9a9a9a;
            --gray-600: #5a5a5a; --border: #d4d4d4;
            --gold: #c9a84c; --gold-light: #e8c97a;
            --cream: #faf8f4;
        }
        html, body { height: 100%; font-family: 'DM Sans', sans-serif; }
        body { display: flex; min-height: 100vh; background: var(--cream); overflow: hidden; }

        /* ══ GLOBAL LOADING BAR ══ */
        #global-loader {
            position: fixed; top: 0; left: 0; right: 0;
            height: 3px; z-index: 99999;
            background: transparent;
            pointer-events: none;
        }
        #global-loader-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
            background-size: 200% 100%;
            animation: shimmerBar 1.5s linear infinite;
            box-shadow: 0 0 10px rgba(201,168,76,0.7), 0 0 4px rgba(201,168,76,0.4);
            border-radius: 0 2px 2px 0;
            transition: width 0.2s ease;
        }
        #global-loader-fill.complete {
            transition: width 0.15s ease, opacity 0.3s ease 0.15s;
            opacity: 0;
        }
        @keyframes shimmerBar {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ══ PAGE LOADING SCREEN ══ */
        #loading-screen {
            position: fixed; inset: 0; z-index: 9998;
            background: #080808;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 36px;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #loading-screen.hide { opacity: 0; visibility: hidden; }

        .ls-brand { display: flex; align-items: center; gap: 16px; }

        /* Building icon stilasi untuk loading */
      

        .ls-text { display: flex; flex-direction: column; gap: 3px; }
        .ls-name {
            font-family: 'DM Mono', monospace;
            font-size: 15px; font-weight: 500;
            letter-spacing: 0.28em;
            color: #ffffff;
            text-transform: uppercase;
        }
        .ls-sub {
            font-family: 'DM Mono', monospace;
            font-size: 10px; font-weight: 300;
            letter-spacing: 0.4em;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .ls-bar-wrap {
            display: flex; flex-direction: column; align-items: center; gap: 12px;
        }
        .ls-bar-track {
            width: 220px; height: 2px;
            background: rgba(255,255,255,0.07);
            border-radius: 99px; overflow: hidden;
        }
        .ls-bar-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 99px;
            box-shadow: 0 0 8px rgba(201,168,76,0.5);
            transition: width 0.15s linear;
        }
        .ls-msg {
            font-family: 'DM Mono', monospace;
            font-size: 10px; letter-spacing: 0.22em;
            color: rgba(255,255,255,0.22);
            text-transform: uppercase;
        }

        /* ══ LEFT PANEL ══ */
        .panel-left { position: relative; width: 50%; min-height: 100vh; overflow: hidden; flex-shrink: 0; }
        .panel-left img { position: absolute; inset: -10%; width: 120%; height: 120%; object-fit: cover; filter: brightness(0.65) saturate(1.1); animation: kenBurns 20s ease-in-out infinite alternate; }
        @keyframes kenBurns {
            0%   { transform: scale(1.0) translate(0%,0%); }
            25%  { transform: scale(1.08) translate(-2%,-1%); }
            50%  { transform: scale(1.05) translate(1.5%,1%); }
            75%  { transform: scale(1.1) translate(-1%,2%); }
            100% { transform: scale(1.03) translate(2%,-2%); }
        }
        .panel-left-overlay { position: absolute; inset: 0; background: linear-gradient(135deg,rgba(0,0,0,0.4) 0%,transparent 60%),linear-gradient(to bottom,rgba(0,0,0,0.1) 0%,rgba(0,0,0,0.08) 40%,rgba(0,0,0,0.72) 100%); }
        .light-sweep { position: absolute; inset: 0; background: linear-gradient(105deg,transparent 30%,rgba(201,168,76,0.06) 50%,transparent 70%); background-size: 300% 100%; animation: sweep 8s ease-in-out infinite; }
        @keyframes sweep { 0%,100%{background-position:-100% 0} 50%{background-position:200% 0} }

        .particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .particle { position: absolute; width: 2px; height: 2px; border-radius: 50%; background: rgba(201,168,76,0.6); animation: floatUp linear infinite; }
        .particle:nth-child(1){left:15%;animation-duration:12s;animation-delay:0s;top:80%}
        .particle:nth-child(2){left:30%;animation-duration:18s;animation-delay:2s;top:90%}
        .particle:nth-child(3){left:50%;animation-duration:14s;animation-delay:4s;top:85%}
        .particle:nth-child(4){left:70%;animation-duration:20s;animation-delay:1s;top:95%}
        .particle:nth-child(5){left:85%;animation-duration:16s;animation-delay:6s;top:88%}
        .particle:nth-child(6){left:22%;animation-duration:22s;animation-delay:3s;top:92%}
        .particle:nth-child(7){left:60%;animation-duration:15s;animation-delay:7s;top:78%}
        .particle:nth-child(8){left:45%;animation-duration:19s;animation-delay:9s;top:96%}
        @keyframes floatUp{0%{transform:translateY(0) scale(1);opacity:0}10%{opacity:1}90%{opacity:.7}100%{transform:translateY(-100vh) scale(.5);opacity:0}}

        /* ══ BRAND / LOGO ══ */
        .brand {
            position: absolute; top: 32px; left: 36px;
            display: flex; align-items: center; gap: 14px;
            text-decoration: none;
            animation: fadeDown 0.8s ease both;
        }

        .logo-svg { width: 40px; height: 40px; flex-shrink: 0; filter: drop-shadow(0 0 6px rgba(201,168,76,0.35)); }

        .brand-text { display: flex; flex-direction: column; gap: 4px; }
        .brand-name-top {
    font-family: 'DM Mono', monospace;
    font-size: 14px; font-weight: 600;
    letter-spacing: 0.2em;
    color: #ffffff;
    line-height: 1;
    text-transform: uppercase;
    text-shadow: 0 1px 8px rgba(0,0,0,0.4);
}
.brand-name-bottom {
    font-family: 'DM Mono', monospace;
    font-size: 9.5px; font-weight: 400;
    letter-spacing: 0em;
    color: #e8c97a;
    line-height: 1;
    text-shadow: 0 1px 6px rgba(0,0,0,0.3);
}
        

        .panel-left-content { position: absolute; bottom: 52px; left: 40px; right: 40px; color: var(--white); animation: fadeUp 1s 0.3s ease both; }
        .tag-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: var(--gold-light); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .tag-label::before { content:''; display:inline-block; width:28px; height:1.5px; background:var(--gold); }
        .headline { font-family: 'Playfair Display', serif; font-size: clamp(36px,4vw,56px); font-weight: 700; line-height: 1.08; color: var(--white); margin-bottom: 22px; letter-spacing: -0.01em; text-shadow: 0 2px 24px rgba(0,0,0,0.3); }
        .headline em { font-style: italic; color: var(--gold-light); }
        .subtext { font-size: 14px; font-weight: 300; color: rgba(255,255,255,0.72); line-height: 1.65; max-width: 360px; }
        .accent-line { position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg,var(--gold) 0%,var(--gold-light) 50%,transparent 100%); animation: lineGrow 1.2s 0.5s ease both; transform-origin: left; }
        @keyframes lineGrow{from{transform:scaleX(0)}to{transform:scaleX(1)}}

        /* ══ RIGHT PANEL ══ */
        .panel-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 60px 40px; position: relative; overflow: hidden; background-color: var(--cream); }
        .panel-right::before { content:''; position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E"); background-size:200px 200px; pointer-events:none; z-index:0; }
        .blob { position:absolute; border-radius:50%; filter:blur(60px); pointer-events:none; z-index:0; }
        .blob-1 { width:340px; height:340px; background:rgba(201,168,76,0.08); top:-80px; right:-60px; animation:blobDrift 12s ease-in-out infinite alternate; }
        .blob-2 { width:280px; height:280px; background:rgba(180,150,100,0.06); bottom:-60px; left:-40px; animation:blobDrift 16s ease-in-out infinite alternate-reverse; }
        .blob-3 { width:200px; height:200px; background:rgba(201,168,76,0.05); top:50%; left:50%; animation:blobDrift 10s ease-in-out infinite alternate; }
        @keyframes blobDrift{0%{transform:translate(0,0) scale(1)}50%{transform:translate(10px,-15px) scale(1.05)}100%{transform:translate(-8px,10px) scale(.97)}}
        .dot-grid { position:absolute; inset:0; background-image:radial-gradient(circle,rgba(180,150,90,0.12) 1px,transparent 1px); background-size:28px 28px; pointer-events:none; z-index:0; mask-image:radial-gradient(ellipse at center,rgba(0,0,0,0.3) 0%,transparent 75%); -webkit-mask-image:radial-gradient(ellipse at center,rgba(0,0,0,0.3) 0%,transparent 75%); }
        .corner-arc { position:absolute; top:-40px; right:-40px; width:220px; height:220px; border:1px solid rgba(201,168,76,0.15); border-radius:50%; pointer-events:none; z-index:0; }
        .corner-arc-2 { position:absolute; top:-70px; right:-70px; width:300px; height:300px; border:1px solid rgba(201,168,76,0.08); border-radius:50%; pointer-events:none; z-index:0; }
        .panel-right-edge { position:absolute; left:0; top:10%; bottom:10%; width:1px; background:linear-gradient(to bottom,transparent,rgba(201,168,76,0.3),transparent); pointer-events:none; z-index:0; }

        .login-card { width:100%; max-width:460px; position:relative; z-index:1; animation:fadeUp 0.9s 0.2s ease both; }
        .card-inner { background:rgba(255,255,255,0.72); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(201,168,76,0.15); border-radius:2px; padding:48px 44px; box-shadow:0 8px 48px rgba(0,0,0,0.06),0 1px 0 rgba(201,168,76,0.2) inset; }

        .section-label { font-family:'DM Mono',monospace; font-size:11px; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); margin-bottom:16px; display:flex; align-items:center; gap:8px; }
        .section-label::after { content:''; flex:1; height:1px; background:linear-gradient(90deg,var(--gold),transparent); max-width:60px; }
        .login-title { font-family:'Playfair Display',serif; font-size:clamp(30px,3vw,42px); font-weight:700; color:var(--black); line-height:1.08; margin-bottom:10px; letter-spacing:-0.02em; }
        .login-subtitle { font-size:14px; color:var(--gray-600); font-weight:300; margin-bottom:36px; }

        .alert-error { background:#fff3f3; border:1px solid #ffc0c0; border-left:3px solid #e74c3c; padding:12px 16px; margin-bottom:24px; font-size:13px; color:#c0392b; }
        .alert-error ul { padding-left:16px; }

        .form-group { margin-bottom:24px; }
        .form-label { display:block; font-family:'DM Mono',monospace; font-size:10.5px; letter-spacing:0.18em; text-transform:uppercase; color:var(--black); margin-bottom:10px; }
        .form-control { width:100%; padding:13px 16px; font-family:'DM Sans',sans-serif; font-size:14px; color:var(--black); background:rgba(255,255,255,0.8); border:1.5px solid rgba(201,168,76,0.2); border-radius:0; outline:none; transition:border-color 0.25s ease,background 0.25s ease,box-shadow 0.25s ease; appearance:none; }
        .form-control::placeholder { color:var(--gray-400); font-weight:300; }
        .form-control:focus { border-color:var(--gold); background:var(--white); box-shadow:0 0 0 3px rgba(201,168,76,0.08); }
        .form-control.is-invalid { border-color:#e74c3c; }
        .invalid-feedback { font-size:12px; color:#e74c3c; margin-top:6px; }

        .password-wrapper { position:relative; }
        .password-wrapper .form-control { padding-right:48px; }
        .toggle-pw { position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--gray-400); padding:4px; display:flex; align-items:center; transition:color 0.2s; }
        .toggle-pw:hover { color:var(--gold); }

        .btn-submit { width:100%; padding:16px; background:#032685; color:var(--white); font-family:'DM Mono',monospace; font-size:12.5px; letter-spacing:0.22em; text-transform:uppercase; border:none; cursor:pointer; position:relative; overflow:hidden; transition:background 0.25s ease,transform 0.15s ease; margin-bottom:24px; }
        .btn-submit::before { content:''; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(201,168,76,0.2),transparent); transform:translateX(-100%); transition:transform 0.6s ease; }
        .btn-submit:hover { background:#2351c8; }
        .btn-submit:hover::before { transform:translateX(100%); }
        .btn-submit:active { transform:scale(0.99); }

        .register-line { font-size:13px; color:var(--gray-600); font-weight:300; }
        .register-line a { color:var(--black); font-weight:500; text-decoration:underline; text-underline-offset:3px; transition:opacity 0.2s; }
        .register-line a:hover { opacity:0.5; }
        .divider { height:1px; background:rgba(201,168,76,0.15); margin-bottom:24px; }

        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeDown{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){
            body{flex-direction:column;overflow:auto}
            .panel-left{width:100%;min-height:280px}
            .panel-right{padding:40px 20px}
            .card-inner{padding:32px 24px}
        }
    </style>
</head>
<body>

<!-- GLOBAL LOADING BAR -->
<div id="global-loader"><div id="global-loader-fill"></div></div>

<!-- PAGE LOADING SCREEN -->
<div id="loading-screen">
    <div class="ls-brand">
        <div class="ls-icon">
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Bangunan utama -->
                <rect x="8" y="18" width="32" height="26" rx="0" fill="none" stroke="#c9a84c" stroke-width="1.5"/>
                <!-- Atap segitiga -->
                <path d="M4 18 L24 5 L44 18" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <!-- Pintu -->
                <rect x="19" y="30" width="10" height="14" rx="0" fill="none" stroke="#e8c97a" stroke-width="1.2"/>
                <!-- Jendela kiri -->
                <rect x="11" y="22" width="7" height="6" rx="0" fill="rgba(201,168,76,0.15)" stroke="#c9a84c" stroke-width="1"/>
                <!-- Jendela kanan -->
                <rect x="30" y="22" width="7" height="6" rx="0" fill="rgba(201,168,76,0.15)" stroke="#c9a84c" stroke-width="1"/>
                <!-- Tiang bendera -->
                <line x1="24" y1="5" x2="24" y2="1" stroke="#e8c97a" stroke-width="1.2" stroke-linecap="round"/>
                <!-- Glow dot puncak -->
                <circle cx="24" cy="1" r="1.5" fill="#e8c97a"/>
            </svg>
        </div>
        <div class="ls-text">
            <span class="ls-name">Kampus</span>
            <span class="ls-sub">/presence</span>
        </div>
    </div>
    <div class="ls-bar-wrap">
        <div class="ls-bar-track"><div class="ls-bar-fill" id="lsBarFill"></div></div>
        <div class="ls-msg" id="lsMsg">Memuat sistem...</div>
    </div>
</div>

<div class="panel-left">
    <img src="{{ asset('images/Gedung.jpg') }}" alt="Kampus">
    <div class="panel-left-overlay"></div>
    <div class="light-sweep"></div>
    <div class="particles">
        <div class="particle"></div><div class="particle"></div>
        <div class="particle"></div><div class="particle"></div>
        <div class="particle"></div><div class="particle"></div>
        <div class="particle"></div><div class="particle"></div>
    </div>

    <a href="{{ url('/') }}" class="brand">
        <svg class="logo-svg" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="18" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
            <path d="M20 8 L32 12.5 L32 19.5 Q32 27 20 31 Q8 27 8 19.5 L8 12.5 Z" fill="none" stroke="white" stroke-width="1.6"/>
            <circle cx="20" cy="17" r="4" fill="none" stroke="#e8c97a" stroke-width="1.6"/>
            <path d="M12 28 Q12 23 20 23 Q28 23 28 28" fill="none" stroke="#e8c97a" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
        <div class="brand-text">
            <span style="color:#fff; font-size:15px; font-weight:700; letter-spacing:0.3px; font-family:'DM Sans',sans-serif;">KAMPUS<span style="color:#a4b2cf; font-weight:400;">/presence</span></span>
        </div>
    </a>
            <!-- Background Circle -->
            <circle cx="24" cy="24" r="21"
                    fill="rgba(255,255,255,0.08)"
                    stroke="rgba(255,255,255,0.2)"
                    stroke-width="1.5"/>
    
            <!-- Graduation Cap -->
            <path d="M24 11L10 17L24 23L38 17L24 11Z"
                  fill="#E8C97A"/>
    
            <path d="M16 21V27.5C16 31.5 20 34.5 24 34.5C28 34.5 32 31.5 32 27.5V21"
                  stroke="white"
                  stroke-width="2"
                  stroke-linecap="round"/>
    
            <!-- Attendance Check -->
            <path d="M18.5 25.5L22.5 29.5L30.5 21.5"
                  stroke="#E8C97A"
                  stroke-width="2.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
    

    <div class="panel-left-content">
        <p class="tag-label">Sistem Kehadiran Dosen</p>
        <h1 class="headline">Tahu kapan<br>dosen ada di <em>ruangan.</em></h1>
        <p class="subtext">Hemat waktu mahasiswa. Dosen update status sekali klik, chatbot AI menjawab sisanya.</p>
    </div>
    <div class="accent-line"></div>
</div>

<div class="panel-right">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="dot-grid"></div>
    <div class="corner-arc"></div>
    <div class="corner-arc-2"></div>
    <div class="panel-right-edge"></div>

    <div class="login-card">
        <div class="card-inner">
            <p class="section-label">Masuk</p>
            <h2 class="login-title">Selamat datang</h2>
            <p class="login-subtitle">Login dengan akun Email Anda.</p>

            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert-error" style="background:#f0fff4;border-color:#a8d5b5;border-left-color:#27ae60;color:#276749;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.id"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <button type="button" class="toggle-pw" onclick="togglePassword('password','eyeLogin')">
                            <svg id="eyeLogin" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-submit" id="btnSubmit">Masuk</button>
            </form>

            <div class="divider"></div>
            <p class="register-line">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>

<script>
/* ══ 1. PAGE LOAD: loading screen ══ */
(function () {
    const screen = document.getElementById('loading-screen');
    const fill   = document.getElementById('lsBarFill');
    const msg    = document.getElementById('lsMsg');
    const msgs   = ['Memuat sistem...', 'Menghubungkan server...', 'Menyiapkan antarmuka...', 'Hampir selesai...'];
    let p = 0, mi = 0;
    const iv = setInterval(() => {
        p += Math.random() * 16 + 6;
        if (p > 100) p = 100;
        fill.style.width = p + '%';
        if (p > 28 && mi === 0) { mi++; msg.textContent = msgs[1]; }
        if (p > 55 && mi === 1) { mi++; msg.textContent = msgs[2]; }
        if (p > 80 && mi === 2) { mi++; msg.textContent = msgs[3]; }
        if (p >= 100) {
            clearInterval(iv);
            setTimeout(() => {
                screen.classList.add('hide');
                setTimeout(() => screen.remove(), 600);
            }, 280);
        }
    }, 110);
})();

/* ══ 2. GLOBAL LOADING BAR — setiap navigasi / klik link & form submit ══ */
const Loader = {
    bar: document.getElementById('global-loader-fill'),
    progress: 0,
    iv: null,
    start() {
        this.progress = 0;
        this.bar.classList.remove('complete');
        this.bar.style.opacity = '1';
        this.bar.style.width = '0%';
        clearInterval(this.iv);
        this.iv = setInterval(() => {
            this.progress += Math.random() * 12 + 4;
            if (this.progress > 85) this.progress = 85;
            this.bar.style.width = this.progress + '%';
        }, 150);
    },
    finish() {
        clearInterval(this.iv);
        this.bar.style.width = '100%';
        setTimeout(() => { this.bar.classList.add('complete'); }, 180);
    }
};

// Semua link <a> yang mengarah ke halaman lain
document.addEventListener('click', function (e) {
    const link = e.target.closest('a[href]');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript') || href.startsWith('mailto')) return;
    if (link.target === '_blank') return;
    Loader.start();
});

// Form submit (login, register, dll)
document.addEventListener('submit', function (e) {
    Loader.start();
});

// Saat halaman selesai load (navigasi balik / cache)
window.addEventListener('pageshow', function () { Loader.finish(); });
window.addEventListener('load', function () { Loader.finish(); });

/* ══ 3. TOGGLE PASSWORD ══ */
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    }
}
</script>
</body>
</html>
