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
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --gray-100: #f5f5f5;
            --gray-200: #e8e8e8;
            --gray-400: #9a9a9a;
            --gray-600: #5a5a5a;
            --accent: #1a1a1a;
            --border: #d4d4d4;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: var(--white);
        }

        /* ─── LEFT PANEL ─── */
        .panel-left {
            position: relative;
            width: 50%;
            min-height: 100vh;
            overflow: hidden;
            flex-shrink: 0;
        }

        .panel-left img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.72);
        }

        .panel-left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.15) 0%,
                rgba(0,0,0,0.05) 40%,
                rgba(0,0,0,0.55) 100%
            );
        }

        .brand {
            position: absolute;
            top: 36px;
            left: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--white);
            text-decoration: none;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            border: 2.5px solid rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon-inner {
            width: 14px;
            height: 14px;
            background: rgba(255,255,255,0.9);
        }

        .brand-name {
            font-family: 'DM Mono', monospace;
            font-size: 14px;
            letter-spacing: 0.02em;
            color: rgba(255,255,255,0.95);
        }

        .panel-left-content {
            position: absolute;
            bottom: 52px;
            left: 40px;
            right: 40px;
            color: var(--white);
        }

        .tag-label {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 20px;
        }

        .headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 4vw, 54px);
            font-weight: 700;
            line-height: 1.1;
            color: var(--white);
            margin-bottom: 20px;
            letter-spacing: -0.01em;
        }

        .subtext {
            font-size: 14px;
            font-weight: 300;
            color: rgba(255,255,255,0.72);
            line-height: 1.6;
            max-width: 380px;
        }

        /* ─── RIGHT PANEL ─── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            background: var(--white);
        }

        .login-card {
            width: 100%;
            max-width: 460px;
        }

        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray-400);
            margin-bottom: 18px;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 3vw, 44px);
            font-weight: 700;
            color: var(--black);
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--gray-600);
            font-weight: 300;
            margin-bottom: 40px;
        }

        /* Alert Errors */
        .alert-error {
            background: #fff3f3;
            border: 1px solid #ffc0c0;
            border-radius: 2px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #c0392b;
        }

        .alert-error ul {
            padding-left: 16px;
        }

        /* Form */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--black);
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 13px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--black);
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 0;
            outline: none;
            transition: border-color 0.2s ease;
            appearance: none;
        }

        .form-control::placeholder {
            color: var(--gray-400);
            font-weight: 300;
        }

        .form-control:focus {
            border-color: var(--black);
        }

        .form-control.is-invalid {
            border-color: #e74c3c;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #e74c3c;
            margin-top: 6px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--black);
            color: var(--white);
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.1s ease;
            margin-bottom: 28px;
        }

        .btn-submit:hover {
            background: #2a2a2a;
        }

        .btn-submit:active {
            transform: scale(0.995);
        }

        /* Register Link */
        .register-line {
            font-size: 13.5px;
            color: var(--gray-600);
            font-weight: 300;
            margin-bottom: 40px;
        }

        .register-line a {
            color: var(--black);
            font-weight: 500;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .register-line a:hover {
            opacity: 0.7;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--gray-200);
            margin-bottom: 28px;
        }

        /* Demo Accounts */
        .demo-label {
            font-family: 'DM Mono', monospace;
            font-size: 10.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gray-400);
            margin-bottom: 12px;
        }

        .demo-accounts {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .demo-item {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-role {
            color: var(--gray-400);
            min-width: 70px;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .panel-left {
                width: 100%;
                min-height: 260px;
            }

            .panel-right {
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>

    {{-- ─── LEFT: Hero Panel ─── --}}
    <div class="panel-left">
        <img src="{{ asset('images/polibatam.jpeg') }}" alt="Kampus">
        <div class="panel-left-overlay"></div>

        <a href="{{ url('images/polibatam.jpg') }}" class="brand">
            <div class="brand-icon">
                <div class="brand-icon-inner"></div>
            </div>
            <span class="brand-name">KAMPUS/presence</span>
        </a>

        <div class="panel-left-content">
            <p class="tag-label">Sistem Kehadiran Dosen</p>
            <h1 class="headline">
                Tahu kapan<br>
                dosen ada di ruangan.
            </h1>
            <p class="subtext">
                Hemat waktu mahasiswa. Dosen update status sekali klik,
                chatbot AI menjawab sisanya.
            </p>
        </div>
    </div>

    {{-- ─── RIGHT: Login Form ─── --}}
    <div class="panel-right">
        <div class="login-card">

            <p class="section-label">Masuk</p>
            <h2 class="login-title">Selamat datang</h2>
            <p class="login-subtitle">Login dengan akun Anda.</p>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session Status (misal setelah logout) --}}
            @if (session('status'))
                <div class="alert-error" style="background:#f0fff4; border-color:#a8d5b5; color:#276749;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@gmail.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Masuk</button>
            </form>
            <div class="divider"></div>
            <p class="register-line">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>

</body>
</html>