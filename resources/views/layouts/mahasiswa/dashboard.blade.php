<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Kampus Presence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; }
        .label-line { width: 24px; height: 1.5px; background: #000; margin-bottom: 6px; }
    </style>
</head>
<body class="text-gray-900">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 py-4 px-6 md:px-12 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="bg-black w-8 h-8 rounded flex items-center justify-center">
                <span class="text-white font-bold text-xs">K/P</span>
            </div>
            <span class="font-bold tracking-tighter text-xl uppercase">Kampus<span class="text-gray-400 font-light lowercase">/presence</span></span>
        </div>
        
        <div class="hidden md:flex gap-8 items-center font-semibold text-sm">
            <a href="#" class="text-black flex items-center gap-2"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
            <a href="#" class="text-gray-400 hover:text-black transition-all flex items-center gap-2"><i class="fa-solid fa-users"></i> Bimbingan</a>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">{{ Auth::user()->role ?? 'MAHASISWA' }}</p>
                <p class="text-sm font-bold">{{ Auth::user()->name ?? 'Rafa Adestia' }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-200 rounded-full border-2 border-black/5 overflow-hidden">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Rafa' }}&background=000&color=fff" alt="Profile">
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6 md:p-12">
        <header class="mb-12">
            <div class="label-line"></div>
            <p class="text-xs font-bold text-gray-400 tracking-[0.2em] uppercase mb-2">Direktori Dosen</p>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight max-w-xl leading-tight">
                Siapa yang ada di kampus hari ini?
            </h1>
        </header>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
            @php
                $stats = [
                    ['label' => 'DI RUANGAN', 'count' => 2, 'color' => 'bg-green-500'],
                    ['label' => 'SEDANG MENGAJAR', 'count' => 2, 'color' => 'bg-orange-500'],
                    ['label' => 'SEDANG BIMBINGAN', 'count' => 1, 'color' => 'bg-blue-500'],
                    ['label' => 'TIDAK ADA', 'count' => 1, 'color' => 'bg-red-500'],
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-1 h-full {{ $stat['color'] }}"></div>
                <p class="text-[10px] font-black text-gray-400 tracking-widest mb-1">{{ $stat['label'] }}</p>
                <p class="text-3xl font-bold">{{ $stat['count'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col lg:flex-row gap-4 mb-8">
            <div class="relative flex-grow">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Cari nama atau ruangan..." class="w-full bg-white border border-gray-200 py-4 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-black/5 focus:border-black transition-all">
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                <button class="bg-black text-white px-6 py-2 text-xs font-bold tracking-widest uppercase whitespace-nowrap">Semua</button>
                <button class="bg-white border border-gray-200 px-6 py-2 text-xs font-bold tracking-widest uppercase hover:bg-gray-50 whitespace-nowrap">Di Ruangan</button>
                <button class="bg-white border border-gray-200 px-6 py-2 text-xs font-bold tracking-widest uppercase hover:bg-gray-50 whitespace-nowrap text-red-500">Tidak Ada</button>
                <button class="bg-white border border-gray-200 px-6 py-2 text-xs font-bold tracking-widest uppercase hover:bg-gray-50 whitespace-nowrap text-orange-500">Mengajar</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 group hover:border-black transition-all duration-300">
                <div class="p-6">
                    <div class="flex gap-4 items-start mb-6">
                        <img src="https://i.pravatar.cc/150?u=1" class="w-16 h-16 grayscale group-hover:grayscale-0 transition-all duration-500 object-cover border border-gray-100 shadow-sm">
                        <div>
                            <div class="label-line"></div>
                            <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase">Dosen</p>
                            <h3 class="font-bold text-lg leading-tight">Dr. Budi Santoso</h3>
                            <div class="mt-2 inline-flex items-center gap-2 bg-green-50 px-2 py-1">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-[10px] font-bold text-green-700 uppercase tracking-tighter">Di Ruangan</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-500 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-location-dot w-4 text-gray-400"></i>
                            <span>Ruang 301</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone w-4 text-gray-400"></i>
                            <span>0811-1111-11</span>
                        </div>
                    </div>

                    <button class="w-full border-2 border-black py-3 text-xs font-black tracking-[0.2em] uppercase hover:bg-black hover:text-white transition-all flex items-center justify-center gap-3">
                        <i class="fa-regular fa-calendar-check"></i>
                        Request Bimbingan
                    </button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 group hover:border-black transition-all">
                <div class="p-6">
                    <div class="flex gap-4 items-start mb-6">
                        <img src="https://i.pravatar.cc/150?u=2" class="w-16 h-16 grayscale group-hover:grayscale-0 transition-all object-cover">
                        <div>
                            <div class="label-line"></div>
                            <p class="text-[9px] font-bold text-gray-400 tracking-widest uppercase">Dosen</p>
                            <h3 class="font-bold text-lg">Dr. Sari Wijaya</h3>
                            <div class="mt-2 inline-flex items-center gap-2 bg-orange-50 px-2 py-1">
                                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                <span class="text-[10px] font-bold text-orange-700 uppercase">Sedang Mengajar</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-500 mb-6">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-location-dot w-4 text-gray-400"></i><span>Ruang 302</span></div>
                        <div class="flex items-center gap-3"><i class="fa-solid fa-phone w-4 text-gray-400"></i><span>0822-2222-22</span></div>
                    </div>
                    <button class="w-full border-2 border-gray-200 py-3 text-xs font-black tracking-[0.2em] uppercase text-gray-400 cursor-not-allowed">
                        Dosen Sedang Sibuk
                    </button>
                </div>
            </div>

        </div>
    </main>

</body>
</html>