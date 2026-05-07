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
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --gray-200: #e8e8e8;
            --gray-400: #9a9a9a;
            --gray-600: #5a5a5a;
            --border: #d4d4d4;
        }

        body {
            display: flex;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
        }

        /* LEFT PANEL */
        .panel-left {
            width: 50%;
            position: relative;
            overflow: hidden;
        }

        .panel-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
        }

        .panel-left-content {
            position: absolute;
            bottom: 50px;
            left: 40px;
            color: white;
        }

        .headline {
            font-family: 'Playfair Display', serif;
            font-size: 44px;
        }

        /* RIGHT PANEL */
        .panel-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .card {
            width: 100%;
            max-width: 420px;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-family: 'DM Mono', monospace;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            margin-top: 8px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        #dosen-only {
            display: none;
        }
    </style>
</head>

<body>

<!-- LEFT -->
<div class="panel-left">
    <img src="{{ asset('images/Gedung.jpg') }}" alt="kampus">
    <div class="overlay"></div>

    <div class="panel-left-content">
        <h1 class="headline">Bergabung<br>dengan sistem.</h1>
    </div>
</div>

<!-- RIGHT -->
<div class="panel-right">
    <div class="card">

        <h2 class="title">Daftar Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- ROLE -->
            <div class="form-group">
                <label>Role</label>
                <select name="role" id="role" onchange="toggleForm()" required>
                    <option value="">Pilih...</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <div id="dynamic-fields" style="display:none;">

                <!-- NAME -->
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required>
                </div>

                <!-- ID -->
                <div class="form-group">
                    <label id="id-label">NIM / NIDN</label>
                    <input type="text" name="id_number" required>
                </div>

                <!-- DOSEN ONLY -->
                <div id="dosen-only">
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp">
                    </div>
                </div>

                <!-- EMAIL -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn">DAFTAR</button>
            </div>

        </form>

    </div>
</div>

<script>
function toggleForm() {
    let role = document.getElementById('role').value;
    let fields = document.getElementById('dynamic-fields');
    let dosen = document.getElementById('dosen-only');
    let label = document.getElementById('id-label');

    fields.style.display = role ? 'block' : 'none';

    if (role === 'dosen') {
        dosen.style.display = 'block';
        label.innerText = "NIDN";
    } else {
        dosen.style.display = 'none';
        label.innerText = "NIM";
    }
}
</script>

</body>
</html>