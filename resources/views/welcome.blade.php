<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMPUS/presence — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --black: #0a0a0a; --white: #ffffff;
            --gray-200: #e8e8e8; --gray-400: #9a9a9a;
            --gray-600: #5a5a5a; --border: #d4d4d4;
        }
        html, body { height: 100%; font-family: 'DM Sans', sans-serif; }
        body { display: flex; min-height: 100vh; background: var(--white); }

        .panel-left { position: relative; width: 50%; min-height: 100vh; overflow: hidden; flex-shrink: 0; }
        .panel-left img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; filter: brightness(0.72); }
        .panel-left-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.05) 40%, rgba(0,0,0,0.55) 100%); }

        .brand { position: absolute; top: 36px; left: 40px; display: flex; align-items: center; gap: 10px; color: var(--white); text-decoration: none; }
        .brand-name { font-family: 'DM Mono', monospace; font-size: 14px; letter-spacing: 0.02em; color: rgba(255,255,255,0.95); }

        .panel-left-content { position: absolute; bottom: 52px; left: 40px; right: 40px; color: var(--white); }
        .tag-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.7); margin-bottom: 20px; }
        .headline { font-family: 'Playfair Display', serif; font-size: clamp(36px, 4vw, 54px); font-weight: 700; line-height: 1.1; color: var(--white); margin-bottom: 20px; letter-spacing: -0.01em; }
        .subtext { font-size: 14px; font-weight: 300; color: rgba(255,255,255,0.72); line-height: 1.6; max-width: 380px; }

        .panel-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 60px 40px; background: var(--white); }
        .login-card { width: 100%; max-width: 460px; }
        .section-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--gray-400); margin-bottom: 18px; }
        .login-title { font-family: 'Playfair Display', serif; font-size: clamp(32px, 3vw, 44px); font-weight: 700; color: var(--black); line-height: 1.1; margin-bottom: 10px; }
        .login-subtitle { font-size: 14px; color: var(--gray-600); font-weight: 300; margin-bottom: 40px; }

        .alert-error { background: #fff3f3; border: 1px solid #ffc0c0; padding: 12px 16px; margin-bottom: 24px; font-size: 13px; color: #c0392b; }
        .alert-error ul { padding-left: 16px; }

        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: 0.16em; text-transform: uppercase; color: var(--black); margin-bottom: 10px; }
        .form-control { width: 100%; padding: 13px 16px; font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--black); background: var(--white); border: 1.5px solid var(--border); border-radius: 0; outline: none; transition: border-color 0.2s ease; appearance: none; }
        .form-control::placeholder { color: var(--gray-400); font-weight: 300; }
        .form-control:focus { border-color: var(--black); }
        .form-control.is-invalid { border-color: #e74c3c; }
        .invalid-feedback { font-size: 12px; color: #e74c3c; margin-top: 6px; }

        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 44px; }
        .toggle-pw { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray-400); padding: 0; display: flex; align-items: center; }
        .toggle-pw:hover { color: var(--black); }

        .btn-submit { width: 100%; padding: 16px; background: var(--black); color: var(--white); font-family: 'DM Mono', monospace; font-size: 13px; letter-spacing: 0.18em; text-transform: uppercase; border: none; cursor: pointer; transition: background 0.2s ease; margin-bottom: 28px; }
        .btn-submit:hover { background: #2a2a2a; }

        .register-line { font-size: 13.5px; color: var(--gray-600); font-weight: 300; margin-bottom: 40px; }
        .register-line a { color: var(--black); font-weight: 500; text-decoration: underline; text-underline-offset: 3px; }
        .register-line a:hover { opacity: 0.7; }
        .divider { height: 1px; background: var(--gray-200); margin-bottom: 28px; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .panel-left { width: 100%; min-height: 260px; }
            .panel-right { padding: 40px 24px; }
        }
    </style>
</head>
<body>

    <div class="panel-left">
        <img src="{{ asset('images/Gedung.jpg') }}" alt="Kampus">
        <div class="panel-left-overlay"></div>

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
            <h1 class="headline">Tahu kapan<br>dosen ada di ruangan.</h1>
            <p class="subtext">Hemat waktu mahasiswa. Dosen update status sekali klik, chatbot AI menjawab sisanya.</p>
        </div>
    </div>

    <div class="panel-right">
        <div class="login-card">
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
                <div class="alert-error" style="background:#f0fff4; border-color:#a8d5b5; color:#276749;">
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

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        // Mata NORMAL saat password TERLIHAT
        icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    } else {
        input.type = 'password';
        // Mata CORET saat password TERSEMBUNYI
        icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    }
}
</script>
</body>
</html>