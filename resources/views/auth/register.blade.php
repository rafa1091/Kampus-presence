<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMPUS/presence — Daftar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin:0; padding:0; }
        body { font-family: 'DM Sans', sans-serif; background: #fff; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { width: 100%; max-width: 520px; padding: 48px; border: 1px solid #e8e8e8; }
        .section-label { font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: .2em; text-transform: uppercase; color: #9a9a9a; margin-bottom: 16px; }
        .title { font-family: 'Playfair Display', serif; font-size: 40px; margin-bottom: 8px; }
        .subtitle { font-size: 14px; color: #5a5a5a; margin-bottom: 36px; }
        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-family: 'DM Mono', monospace; font-size: 11px; letter-spacing: .16em; text-transform: uppercase; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 13px 16px; border: 1.5px solid #d4d4d4; font-size: 14px; outline: none; font-family: 'DM Sans', sans-serif; }
        .form-control:focus { border-color: #000; }
        .form-control.is-invalid { border-color: #e74c3c; }
        .invalid-feedback { font-size: 12px; color: #e74c3c; margin-top: 6px; }
        .alert-error { background: #fff3f3; border: 1px solid #ffc0c0; padding: 12px 16px; margin-bottom: 24px; font-size: 13px; color: #c0392b; }
        .alert-error ul { padding-left: 16px; }
        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 44px; }
        .toggle-pw { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9a9a9a; padding: 0; display: flex; align-items: center; }
        .toggle-pw:hover { color: #000; }
        .btn-submit { width: 100%; padding: 16px; background: #0a0a0a; color: #fff; font-family: 'DM Mono', monospace; letter-spacing: .18em; border: none; cursor: pointer; margin-top: 12px; font-size: 13px; text-transform: uppercase; }
        .btn-submit:hover { background: #2a2a2a; }
        .login-link { margin-top: 28px; font-size: 13px; color: #5a5a5a; }
        .login-link a { color: #000; text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">
    <p class="section-label">Daftar</p>
    <h2 class="title">Buat akun baru</h2>
    <p class="subtitle">Gunakan NIM / NIP yang terdaftar di sistem kampus.</p>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">NIM / NIP</label>
            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                <button type="button" class="toggle-pw" onclick="togglePassword('password', 'eye1')">
                    <svg id="eye1" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div class="password-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation', 'eye2')">
                    <svg id="eye2" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">Daftar</button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    }
}
</script>
</body>
</html>