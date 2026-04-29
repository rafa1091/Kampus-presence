<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Garis dekoratif di atas label */
        .label-line {
            display: block;
            width: 30px;
            height: 1px;
            background-color: #000;
            margin-bottom: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 border border-gray-200 shadow-sm w-full max-w-xl">
        <div class="mb-8">
            
            <span class="text-[10px] tracking-widest uppercase font-semibold text-gray-500">Daftar</span>
            <h1 class="text-3xl font-bold mt-2">Buat akun baru</h1>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-5">
               
                <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">Saya Adalah</label>
                <div class="relative">
                    <select name="role" class="w-full border border-gray-300 p-3 bg-white appearance-none focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    
                    <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-3 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div>
                    
                    <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">NIM</label>
                    <input type="text" name="nim" class="w-full border border-gray-300 p-3 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    
                    <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-3 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div>
                   
                    <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-3 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            <div class="mb-8">
               
                <label class="text-[10px] tracking-widest uppercase font-bold mb-1 block">No. HP</label>
                <input type="text" name="phone" class="w-full border border-gray-300 p-3 focus:outline-none focus:ring-1 focus:ring-black">
            </div>

            <button type="submit" class="w-full bg-[#1a1a1a] text-white font-bold py-4 tracking-widest hover:bg-black transition-colors">
                DAFTAR
            </button>

            <div class="mt-6 text-sm text-gray-500">
                Sudah punya akun? <a href="/login" class="text-black font-bold underline">Masuk</a>
            </div>
        </form>
    </div>

</body>
</html>