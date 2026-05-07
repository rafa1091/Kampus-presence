@extends('layouts.app')

@section('content')
<div class="grid-dashboard">

    <div class="card main-card">

        <div class="status-header">
            <small>STATUS SAYA</small>
            <span class="badge-status">● SEDANG MENGAJAR</span>
        </div>

        <h1>Halo, {{ auth()->user()->name }}</h1>
        <p>Perbarui status agar mahasiswa tahu keberadaan Anda.</p>

        <div class="status-grid">
            <div class="status-box green">Di Ruangan</div>
            <div class="status-box active">Sedang Mengajar</div>
            <div class="status-box blue">Sedang Bimbingan</div>
            <div class="status-box red">Tidak Ada</div>
        </div>

        <textarea class="textarea" placeholder="Masukkan Catatan..."></textarea>

    </div>

    <div class="card side-card">

        <label>RUANGAN</label>
        <input type="text">

        <label>NO.HP</label>
        <input type="text">

        <button class="btn-black">SIMPAN PROFIL</button>

    </div>

</div>
@endsection