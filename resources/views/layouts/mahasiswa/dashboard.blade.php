@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto px-12 py-10 pb-24">

    {{-- HEADER --}}
    <header class="mb-8">
        <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Direktori Dosen</p>
        <div class="flex justify-between items-end gap-6">
            <h1 class="text-[32px] font-extrabold leading-tight tracking-tight max-w-[300px]">
                Siapa yang ada di kampus hari ini?
            </h1>
            <div class="flex border border-gray-200" id="statsRow">
                <button onclick="setStatFilter(this,'di-ruangan')"
                        class="stat-card w-[150px] py-5 px-4 text-center flex flex-col justify-center transition-all bg-black border-r border-gray-200">
                    <p class="text-[28px] font-extrabold tracking-tight leading-none text-white" id="statDiRuangan">0</p>
                    <p class="text-[8px] font-bold uppercase tracking-[0.15em] mt-2 text-white">Di Ruangan</p>
                </button>
                <button onclick="setStatFilter(this,'sedang-mengajar')"
                        class="stat-card w-[150px] py-5 px-4 text-center flex flex-col justify-center transition-all border-r border-gray-200">
                    <p class="text-[28px] font-extrabold tracking-tight leading-none text-gray-300" id="statMengajar">0</p>
                    <p class="text-[8px] font-bold uppercase tracking-[0.15em] mt-2 text-gray-300">Sedang Mengajar</p>
                </button>
                <button onclick="setStatFilter(this,'sedang-bimbingan')"
                        class="stat-card w-[150px] py-5 px-4 text-center flex flex-col justify-center transition-all border-r border-gray-200">
                    <p class="text-[28px] font-extrabold tracking-tight leading-none text-gray-300" id="statBimbingan">0</p>
                    <p class="text-[8px] font-bold uppercase tracking-[0.15em] mt-2 text-gray-300">Sedang Bimbingan</p>
                </button>
                <button onclick="setStatFilter(this,'tidak-ada')"
                        class="stat-card w-[150px] py-5 px-4 text-center flex flex-col justify-center transition-all">
                    <p class="text-[28px] font-extrabold tracking-tight leading-none text-gray-300" id="statTidakAda">0</p>
                    <p class="text-[8px] font-bold uppercase tracking-[0.15em] mt-2 text-gray-300">Tidak Ada</p>
                </button>
            </div>
        </div>
    </header>

    {{-- TOOLBAR --}}
    <div class="flex gap-2.5 mb-7">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari nama atau ruangan..."
                   class="w-full h-9 border border-gray-200 pl-8 pr-3 text-[12px] bg-white outline-none focus:border-black transition-colors placeholder-gray-400">
        </div>
        <div class="flex border border-gray-200">
            <button onclick="setFilter(this,'semua')"            class="filter-btn h-9 px-3.5 text-[9px] font-bold uppercase tracking-wide bg-black text-white">Semua</button>
            <button onclick="setFilter(this,'di-ruangan')"       class="filter-btn h-9 px-3.5 text-[9px] font-bold uppercase tracking-wide border-l border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors">Di Ruangan</button>
            <button onclick="setFilter(this,'tidak-ada')"        class="filter-btn h-9 px-3.5 text-[9px] font-bold uppercase tracking-wide border-l border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors">Tidak Ada</button>
            <button onclick="setFilter(this,'sedang-mengajar')"  class="filter-btn h-9 px-3.5 text-[9px] font-bold uppercase tracking-wide border-l border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors">Sedang Mengajar</button>
            <button onclick="setFilter(this,'sedang-bimbingan')" class="filter-btn h-9 px-3.5 text-[9px] font-bold uppercase tracking-wide border-l border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors">Sedang Bimbingan</button>
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-3 gap-4" id="dosenGrid"></div>
</div>

{{-- ═══════════════════════ MODAL REQUEST BIMBINGAN ═══════════════════════ --}}
<div id="modalOverlay" class="fixed inset-0 z-[60] bg-black/60 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-[460px] mx-4 p-8 relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 w-7 h-7 flex items-center justify-center hover:bg-gray-100 transition-colors text-gray-400 hover:text-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Request Bimbingan</p>
        <h2 class="text-[22px] font-extrabold tracking-tight mb-6">Ajukan jadwal bimbingan</h2>
        <p class="text-[11px] text-gray-500 mb-6 -mt-2">dengan <span id="modalDosenName" class="font-bold text-black"></span></p>

        <div class="flex gap-4 mb-4">
            <div class="flex-1">
                <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Tanggal</label>
                <input type="date" id="inputTanggal" class="w-full h-10 border border-gray-200 px-3 text-[12px] outline-none focus:border-black transition-colors">
            </div>
            <div class="flex-1">
                <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Jam</label>
                <input type="time" id="inputJam" class="w-full h-10 border border-gray-200 px-3 text-[12px] outline-none focus:border-black transition-colors">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Topik</label>
            <input type="text" id="inputTopik" placeholder="mis. Bab 3 skripsi"
                   class="w-full h-10 border border-gray-200 px-3 text-[12px] outline-none focus:border-black transition-colors placeholder-gray-300">
        </div>
        <div class="mb-6">
            <label class="block text-[9px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Catatan</label>
            <textarea id="inputCatatan" rows="4"
                      class="w-full border border-gray-200 px-3 py-2.5 text-[12px] outline-none focus:border-black transition-colors resize-none"></textarea>
        </div>
        <div id="modalError" class="text-red-500 text-[11px] mb-3 hidden"></div>
        <button onclick="submitRequest()"
                class="w-full h-11 bg-black text-white text-[10px] font-bold uppercase tracking-widest hover:bg-gray-900 transition-colors">
            Kirim Request
        </button>
    </div>
</div>

{{-- ═══════════════════════ TOAST ═══════════════════════ --}}
<div id="toast" class="fixed top-6 right-6 z-[70] bg-black text-white px-5 py-3 text-[11px] font-bold uppercase tracking-wide hidden shadow-lg">
    ✓ Request berhasil dikirim!
</div>

{{-- ═══════════════════════ CHATBOT FAB ═══════════════════════ --}}
<button id="chatFab" onclick="toggleChat()"
        class="fixed bottom-8 right-8 z-50 w-12 h-12 bg-black flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
    <svg class="w-5 h-5" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
    </svg>
</button>

{{-- Chat Window --}}
<div id="chatWindow" class="fixed bottom-24 right-8 z-50 w-[340px] bg-white border border-gray-200 shadow-2xl hidden flex-col" style="height:480px;">
    <div class="bg-black text-white px-4 py-3 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-2.5">
            <div class="w-6 h-6 bg-white/20 flex items-center justify-center text-[10px]">✦</div>
            <div>
                <p class="text-[12px] font-bold">Asisten Kampus</p>
                <p class="text-[9px] text-white/50 uppercase tracking-wide">AI · Online</p>
            </div>
        </div>
        <button onclick="toggleChat()" class="text-white/60 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <div id="chatMessages" class="flex-1 overflow-y-auto px-4 py-4 flex flex-col gap-3 text-[12px]">
        <div class="bg-gray-100 px-3 py-2.5 max-w-[85%] leading-relaxed text-[12px]">
            Halo! Saya Asisten Kampus. Tanya apa saja tentang dosen, jadwal, atau bimbingan 😊
        </div>
    </div>
    <div class="border-t border-gray-200 px-3 py-3 flex gap-2 shrink-0">
        <input id="chatInput" type="text" placeholder="Tanya apa saja..."
               class="flex-1 text-[12px] border border-gray-200 px-3 py-2 outline-none focus:border-black transition-colors"
               onkeydown="if(event.key==='Enter')sendChat()">
        <button onclick="sendChat()" class="w-9 h-9 bg-black flex items-center justify-center hover:bg-gray-800 transition-colors shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>
</div>

<script>
// ── DATA DOSEN (dari Laravel via Blade) ──
// Ganti ini nanti dengan data dari controller:
{{-- const dosenData = @json($dosens); --}}
const dosenData = [
    { id:1, nama:"Admin Kampus",       status:"di-ruangan",       ruangan:"Ruang Admin", telp:null,         foto:"https://i.pravatar.cc/150?img=12", catatan:null },
    { id:2, nama:"Dr. Budi Santoso",   status:"di-ruangan",       ruangan:"Ruang 301",   telp:"0811111111", foto:"https://i.pravatar.cc/150?img=20", catatan:null },
    { id:3, nama:"Dr. Sari Wijaya",    status:"sedang-mengajar",  ruangan:"Ruang 302",   telp:"02222222",   foto:"https://i.pravatar.cc/150?img=47", catatan:null },
    { id:4, nama:"Prof. Ahmad Rahman", status:"sedang-bimbingan", ruangan:"Ruang 303",   telp:"0933333333", foto:"https://i.pravatar.cc/150?img=60", catatan:null },
    { id:5, nama:"Dr. Linda Kusuma",   status:"tidak-ada",        ruangan:"Ruang 304",   telp:"0844444444", foto:"https://i.pravatar.cc/150?img=25", catatan:"Sedang rapat fakultas" },
    { id:6, nama:"Hamdani",            status:"tidak-ada",        ruangan:"Ruang 701",   telp:"0897865645", foto:null,                               catatan:null },
];

let requests = JSON.parse(localStorage.getItem('kp_requests') || '[]');
let currentDosen = null;
let currentFilter = 'semua';
let chatHistory = [];

const statusConfig = {
    'di-ruangan':      { dot:'bg-green-500',  label:'Di Ruangan' },
    'sedang-mengajar': { dot:'bg-yellow-400', label:'Sedang Mengajar' },
    'sedang-bimbingan':{ dot:'bg-blue-500',   label:'Sedang Bimbingan' },
    'tidak-ada':       { dot:'bg-red-500',    label:'Tidak Ada' },
};

// ── RENDER CARDS ──
function renderCards(list) {
    const grid = document.getElementById('dosenGrid');
    if (!list.length) {
        grid.innerHTML = `<div class="col-span-3 text-center py-16 text-gray-400 text-[12px] font-bold uppercase tracking-widest">Tidak ada dosen ditemukan</div>`;
        return;
    }
    grid.innerHTML = list.map(d => {
        const s = statusConfig[d.status];
        const avatarHtml = d.foto
            ? `<img src="${d.foto}" class="w-full h-full object-cover grayscale">`
            : `<div class="w-full h-full bg-gray-800 flex items-center justify-center text-white text-xl font-bold">${d.nama[0]}</div>`;
        const telpHtml = d.telp
            ? `<div class="flex items-center gap-1 text-[9px] font-bold text-gray-400 mt-1">
                <svg class="w-2.5 h-2.5 fill-gray-400" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                ${d.telp}
               </div>` : '';
        const catatanHtml = d.catatan
            ? `<div class="text-[10px] text-gray-400 italic mt-1 border-l-2 border-gray-200 pl-2">"${d.catatan}"</div>` : '';
        return `
        <div class="card bg-white border border-gray-200 p-5 hover:border-gray-400 hover:shadow-md transition-all" data-status="${d.status}">
            <div class="flex gap-3.5 mb-4">
                <div class="w-14 h-14 bg-gray-200 shrink-0 overflow-hidden">${avatarHtml}</div>
                <div>
                    <p class="text-[8px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dosen</p>
                    <p class="text-[15px] font-extrabold tracking-tight mb-2">${d.nama}</p>
                    <span class="inline-flex items-center gap-1.5 px-2 py-1 border border-gray-200 text-[8px] font-bold uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 rounded-full ${s.dot} shrink-0"></span>${s.label}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wide text-gray-400 mb-1">
                <svg class="w-2.5 h-2.5 fill-gray-400 shrink-0" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
                ${d.ruangan}
            </div>
            ${telpHtml}
            ${catatanHtml}
            <button onclick="openModal(${d.id})"
                    class="w-full h-[34px] mt-4 border border-gray-800 text-[9px] font-bold uppercase tracking-widest flex items-center justify-center gap-1.5 hover:bg-black hover:text-white transition-colors">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Request Bimbingan
            </button>
        </div>`;
    }).join('');
}

function applyFilter() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const filtered = dosenData.filter(d => {
        const matchStatus = currentFilter === 'semua' || d.status === currentFilter;
        const matchSearch = !q || d.nama.toLowerCase().includes(q) || d.ruangan.toLowerCase().includes(q);
        return matchStatus && matchSearch;
    });
    renderCards(filtered);
    updateStats();
}

function updateStats() {
    document.getElementById('statDiRuangan').textContent  = dosenData.filter(d => d.status === 'di-ruangan').length;
    document.getElementById('statMengajar').textContent   = dosenData.filter(d => d.status === 'sedang-mengajar').length;
    document.getElementById('statBimbingan').textContent  = dosenData.filter(d => d.status === 'sedang-bimbingan').length;
    document.getElementById('statTidakAda').textContent   = dosenData.filter(d => d.status === 'tidak-ada').length;
}

function setStatFilter(btn, status) {
    document.querySelectorAll('.stat-card').forEach(b => {
        b.classList.remove('bg-black');
        b.querySelectorAll('p').forEach(p => { p.classList.remove('text-white'); p.classList.add('text-gray-300'); });
    });
    btn.classList.add('bg-black');
    btn.querySelectorAll('p').forEach(p => { p.classList.remove('text-gray-300'); p.classList.add('text-white'); });
    currentFilter = status;
    document.querySelectorAll('.filter-btn').forEach(b => { b.classList.remove('bg-black','text-white'); b.classList.add('text-gray-500'); });
    applyFilter();
}

function setFilter(btn, status) {
    currentFilter = status;
    document.querySelectorAll('.filter-btn').forEach(b => { b.classList.remove('bg-black','text-white'); b.classList.add('text-gray-500'); });
    btn.classList.add('bg-black','text-white');
    btn.classList.remove('text-gray-500');
    applyFilter();
}

document.getElementById('searchInput').addEventListener('input', applyFilter);

// ── MODAL ──
function openModal(dosenId) {
    currentDosen = dosenData.find(d => d.id === dosenId);
    document.getElementById('modalDosenName').textContent = currentDosen.nama;
    ['inputTanggal','inputJam','inputTopik','inputCatatan'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('modalError').classList.add('hidden');
    document.getElementById('modalOverlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modalOverlay').classList.add('hidden');
    document.body.style.overflow = '';
    currentDosen = null;
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

function submitRequest() {
    const tanggal = document.getElementById('inputTanggal').value;
    const jam     = document.getElementById('inputJam').value;
    const topik   = document.getElementById('inputTopik').value.trim();
    const catatan = document.getElementById('inputCatatan').value.trim();
    const errEl   = document.getElementById('modalError');

    if (!tanggal || !jam || !topik) {
        errEl.textContent = 'Tanggal, jam, dan topik wajib diisi.';
        errEl.classList.remove('hidden');
        return;
    }
    errEl.classList.add('hidden');

    const newReq = { id: Date.now(), dosenId: currentDosen.id, dosenNama: currentDosen.nama, tanggal, jam, topik, catatan, status: 'pending', createdAt: new Date().toISOString() };
    requests.push(newReq);
    localStorage.setItem('kp_requests', JSON.stringify(requests));
    closeModal();
    showToast(`Request ke ${newReq.dosenNama} berhasil dikirim!`);
}

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = '✓ ' + msg;
    t.classList.remove('hidden');
    setTimeout(() => t.classList.add('hidden'), 3000);
}

// ── CHATBOT ──
function toggleChat() {
    const w = document.getElementById('chatWindow');
    w.classList.toggle('hidden');
    w.classList.toggle('flex');
    if (!w.classList.contains('hidden')) document.getElementById('chatInput').focus();
}

async function sendChat() {
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;
    input.value = '';
    appendMessage(msg, 'user');
    chatHistory.push({ role: 'user', content: msg });
    const typing = appendMessage('...', 'bot', true);

    const dosenContext = dosenData.map(d =>
        `- ${d.nama}: status=${statusConfig[d.status].label}, ruangan=${d.ruangan}${d.telp?', telp='+d.telp:''}${d.catatan?', catatan="'+d.catatan+'"':''}`
    ).join('\n');
    const reqContext = requests.length
        ? '\n\nRequest bimbingan yang sudah diajukan:\n' + requests.map(r => `- ke ${r.dosenNama}: ${r.tanggal} ${r.jam}, topik="${r.topik}", status=${r.status}`).join('\n')
        : '';
    const systemPrompt = `Kamu adalah Asisten Kampus KAMPUS/presence yang membantu mahasiswa mencari informasi dosen dan bimbingan.\nData dosen saat ini:\n${dosenContext}${reqContext}\n\nJawab dengan ramah, singkat, dan informatif dalam Bahasa Indonesia.`;

    try {
        const res = await fetch('https://api.anthropic.com/v1/messages', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ model: 'claude-sonnet-4-20250514', max_tokens: 1000, system: systemPrompt, messages: chatHistory })
        });
        const data = await res.json();
        const reply = data.content?.[0]?.text || 'Maaf, saya tidak bisa menjawab saat ini.';
        typing.remove();
        appendMessage(reply, 'bot');
        chatHistory.push({ role: 'assistant', content: reply });
    } catch {
        typing.remove();
        appendMessage('Maaf, koneksi bermasalah. Coba lagi ya.', 'bot');
    }
}

function appendMessage(text, role, isTyping = false) {
    const msgs = document.getElementById('chatMessages');
    const div = document.createElement('div');
    div.className = role === 'user'
        ? 'ml-auto bg-black text-white px-3 py-2.5 max-w-[85%] text-[12px] leading-relaxed'
        : 'bg-gray-100 px-3 py-2.5 max-w-[85%] text-[12px] leading-relaxed';
    div.textContent = text;
    if (isTyping) div.classList.add('animate-pulse');
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div;
}

// ── INIT ──
applyFilter();
</script>
@endsection