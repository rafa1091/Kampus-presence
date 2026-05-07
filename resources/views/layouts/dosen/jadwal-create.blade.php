@extends('layouts.app')

@section('content')

<h1>Tambah Jadwal</h1>

<div class="card">

<form>

    <select>
        <option>Senin</option>
        <option>Selasa</option>
        <option>Rabu</option>
        <option>Kamis</option>
        <option>Jumat</option>
    </select>

    <input type="time">
    <input type="time">
    <input type="text" placeholder="Aktivitas">

    <button class="btn-black">+ TAMBAH</button>

</form>

</div>

@endsection