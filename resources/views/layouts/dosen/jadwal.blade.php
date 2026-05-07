@extends('layouts.app')

@section('content')
<h1>Jadwal Mengajar</h1>

<div class="card">
    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>Hari</th>
            <th>Jam</th>
            <th>Kegiatan</th>
        </tr>

        <tr>
            <td>Senin</td>
            <td>08:00 - 10:00</td>
            <td>Algoritma</td>
        </tr>

        <tr>
            <td>Selasa</td>
            <td>10:00 - 12:00</td>
            <td>PBO</td>
        </tr>
    </table>
</div>
@endsection