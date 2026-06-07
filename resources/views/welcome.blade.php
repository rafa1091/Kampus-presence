<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMPUS/presence — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --black: #0a0a0a; --white: #ffffff;
            --gray-200: #e8e8e8; --gray-400: #9a9a9a;
            --gray-600: #5a5a5a; --border: #d4d4d4;
            --gold: #c9a84c; --gold-light: #e8c97a;
            --cream: #faf8f4; --cream-dark: #f2ede4;
        }
        html, body { height: 100%; font-family: 'DM Sans', sans-serif; }
        body { display: flex; min-height: 100vh; background: var(--cream); overflow: hidden; }

        /* ── LEFT PANEL ── */
        .panel-left { position: relative; width: 50%; min-height: 100vh; overflow: hidden; flex-shrink: 0; }
        .panel-left img { position: absolute; inset: -10%; width: 120%; height: 120%; object-fit: cover; filter: brightness(0.65) saturate(1.1); animation: kenBurns 20s ease-in-out infinite alternate; transform-origin: center center; }
        @keyframes kenBurns {
            0%   { transform: scale(1.0) translate(0%, 0%); }
            25%  { transform: scale(1.08) translate(-2%, -1%); }
            50%  { transform: scale(1.05) translate(1.5%, 1%); }
            75%  { transform: scale(1.1) translate(-1%, 2%); }
            100% { transform: scale(1.03) translate(2%, -2%); }
        }
        .panel-left-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, transparent 60%), linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.08) 40%, rgba(0,0,0,0.72) 100%); }
        .light-sweep { position: absolute; inset: 0; background: linear-gradient(105deg, transparent 30%, rgba(201,168,76,0.06) 50%, transparent 70%); background-size: 300% 100%; animation: sweep 8s ease-in-out infinite; }
        @keyframes sweep { 0%, 100% { background-position: -100% 0; } 50% { background-position: 200% 0; } }

        .particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .particle { position: absolute; width: 2px; height: 2px; border-radius: 50%; background: rgba(201,168,76,0.6); animation: float linear infinite; }
        .particle:nth-child(1) { left: 15%; animation-duration: 12s; animation-delay: 0s;  top: 80%; }
        .particle:nth-child(2) { left: 30%; animation-duration: 18s; animation-delay: 2s;  top: 90%; }
        .particle:nth-child(3) { left: 50%; animation-duration: 14s; animation-delay: 4s;  top: 85%; }
        .particle:nth-child(4) { left: 70%; animation-duration: 20s; animation-delay: 1s;  top: 95%; }
        .particle:nth-child(5) { left: 85%; animation-duration: 16s; animation-delay: 6s;  top: 88%; }
        .particle:nth-child(6) { left: 22%; animation-duration: 22s; animation-delay: 3s;  top: 92%; }
        .particle:nth-child(7) { left: 60%; animation-duration: 15s; animation-delay: 7s;  top: 78%; }
        .particle:nth-child(8) { left: 45%; animation-duration: 19s; animation-delay: 9s;  top: 96%; }
        @keyframes float { 0% { transform: translateY(0) scale(1); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 0.7; } 100% { transform: translateY(-100vh) scale(0.5); opacity: 0; } }

        .brand { position: absolute; top: 36px; left: 40px; display: flex; align-items: center; gap: 10px; color: var(--white); text-decoration: none; animation: fadeDown 0.8s ease both; }
        .brand-name { font-family: 'DM Mono', monospace; font-size: 14px; letter-spacing: 0.06em; color: rgba(255,255,255,0.95); }
        .panel-left-content { position: absolute; bottom: 52px; left: 40px; right: 40px; color: var(--white); animation: fadeUp 1s 0.3s ease both; }
        .tag-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: var(--gold-light); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .tag-label::before { content: ''; display: inline-block; width: 28px; height: 1.5px; background: var(--gold); }
        .headline { font-family: 'Playfair Display', serif; font-size: clamp(36px, 4vw, 56px); font-weight: 700; line-height: 1.08; color: var(--white); margin-bottom: 22px; letter-spacing: -0.01em; text-shadow: 0 2px 24px rgba(0,0,0,0.3); }
        .headline em { font-style: italic; color: var(--gold-light); }
        .subtext { font-size: 14px; font-weight: 300; color: rgba(255,255,255,0.72); line-height: 1.65; max-width: 360px; }
        .accent-line { position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 50%, transparent 100%); animation: lineGrow 1.2s 0.5s ease both; transform-origin: left; }
        @keyframes lineGrow { from { transform: scaleX(0); } to { transform: scaleX(1); } }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
            background-color: var(--cream);
        }

        /* Noise texture overlay */
        .panel-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            pointer-events: none;
            z-index: 0;
        }

        /* Soft radial glow blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }
        .blob-1 { width: 340px; height: 340px; background: rgba(201,168,76,0.08); top: -80px; right: -60px; animation: blobDrift 12s ease-in-out infinite alternate; }
        .blob-2 { width: 280px; height: 280px; background: rgba(180,150,100,0.06); bottom: -60px; left: -40px; animation: blobDrift 16s ease-in-out infinite alternate-reverse; }
        .blob-3 { width: 200px; height: 200px; background: rgba(201,168,76,0.05); top: 50%; left: 50%; transform: translate(-50%,-50%); animation: blobDrift 10s ease-in-out infinite alternate; }
        @keyframes blobDrift {
            0%   { transform: translate(0, 0) scale(1); }
            50%  { transform: translate(10px, -15px) scale(1.05); }
            100% { transform: translate(-8px, 10px) scale(0.97); }
        }

        /* Soft dot grid pattern */
        .dot-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(180,150,90,0.12) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
            z-index: 0;
            mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.3) 0%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.3) 0%, transparent 75%);
        }

        /* Decorative corner arc */
        .corner-arc {
            position: absolute;
            top: -40px; right: -40px;
            width: 220px; height: 220px;
            border: 1px solid rgba(201,168,76,0.15);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        .corner-arc-2 {
            position: absolute;
            top: -70px; right: -70px;
            width: 300px; height: 300px;
            border: 1px solid rgba(201,168,76,0.08);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Thin gold line left edge */
        .panel-right-edge {
            position: absolute;
            left: 0; top: 10%; bottom: 10%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(201,168,76,0.3), transparent);
            pointer-events: none;
            z-index: 0;
        }

        /* Login card */
        .login-card { width: 100%; max-width: 460px; position: relative; z-index: 1; animation: fadeUp 0.9s 0.2s ease both; }

        /* Card glass effect */
        .card-inner {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(201,168,76,0.15);
            border-radius: 2px;
            padding: 48px 44px;
            box-shadow: 0 8px 48px rgba(0,0,0,0.06), 0 1px 0 rgba(201,168,76,0.2) inset;
        }

        .section-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.22em; text-transform: uppercase; color: var(--gold); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .section-label::after { content: ''; flex: 1; height: 1px; background: linear-gradient(90deg, var(--gold), transparent); max-width: 60px; }
        .login-title { font-family: 'Playfair Display', serif; font-size: clamp(30px, 3vw, 42px); font-weight: 700; color: var(--black); line-height: 1.08; margin-bottom: 10px; letter-spacing: -0.02em; }
        .login-subtitle { font-size: 14px; color: var(--gray-600); font-weight: 300; margin-bottom: 36px; }

        .alert-error { background: #fff3f3; border: 1px solid #ffc0c0; border-left: 3px solid #e74c3c; padding: 12px 16px; margin-bottom: 24px; font-size: 13px; color: #c0392b; }
        .alert-error ul { padding-left: 16px; }

        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-family: 'DM Mono', monospace; font-size: 10.5px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--black); margin-bottom: 10px; }
        .form-control { width: 100%; padding: 13px 16px; font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--black); background: rgba(255,255,255,0.8); border: 1.5px solid rgba(201,168,76,0.2); border-radius: 0; outline: none; transition: border-color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease; appearance: none; }
        .form-control::placeholder { color: var(--gray-400); font-weight: 300; }
        .form-control:focus { border-color: var(--gold); background: var(--white); box-shadow: 0 0 0 3px rgba(201,168,76,0.08); }
        .form-control.is-invalid { border-color: #e74c3c; }
        .invalid-feedback { font-size: 12px; color: #e74c3c; margin-top: 6px; }

        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 48px; }
        .toggle-pw { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray-400); padding: 4px; display: flex; align-items: center; transition: color 0.2s; }
        .toggle-pw:hover { color: var(--gold); }

        .btn-submit { width: 100%; padding: 16px; background: var(--black); color: var(--white); font-family: 'DM Mono', monospace; font-size: 12.5px; letter-spacing: 0.22em; text-transform: uppercase; border: none; cursor: pointer; position: relative; overflow: hidden; transition: background 0.25s ease, transform 0.15s ease; margin-bottom: 24px; }
        .btn-submit::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(201,168,76,0.2), transparent); transform: translateX(-100%); transition: transform 0.6s ease; }
        .btn-submit:hover { background: #1a1a1a; }
        .btn-submit:hover::before { transform: translateX(100%); }
        .btn-submit:active { transform: scale(0.99); }

        .register-line { font-size: 13px; color: var(--gray-600); font-weight: 300; }
        .register-line a { color: var(--black); font-weight: 500; text-decoration: underline; text-underline-offset: 3px; transition: opacity 0.2s; }
        .register-line a:hover { opacity: 0.5; }
        .divider { height: 1px; background: rgba(201,168,76,0.15); margin-bottom: 24px; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .panel-left { width: 100%; min-height: 280px; }
            .panel-right { padding: 40px 20px; }
            .card-inner { padding: 32px 24px; }
        }
    </style>
</head>
<body>

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
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="28" height="28" fill="white" fill-opacity="0.15"/>
                <path d="M14 7L22 11L14 15L6 11L14 7Z" fill="white"/>
                <path d="M10 13V18C10 18 11.5 20 14 20C16.5 20 18 18 18 18V13" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="22" y1="11" x2="22" y2="17" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="brand-name">KAMPUS/presence</span>
        </a>
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
                <p class="login-subtitle">Login dengan akun kampus Anda.</p>

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
                    <div class="alert-error" style="background:#f0fff4; border-color:#a8d5b5; border-left-color:#27ae60; color:#276749;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@campus.id"
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
                            <button type="button" class="toggle-pw" onclick="togglePassword('password', 'eyeLogin')">
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

                    <button type="submit" class="btn-submit">Masuk</button>
                </form>

                <div class="divider"></div>
                <p class="register-line">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
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
ENDOFFILE