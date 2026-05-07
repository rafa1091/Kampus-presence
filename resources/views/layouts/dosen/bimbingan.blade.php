@extends('layouts.app')

@section('content')

<h1>Bimbingan Mahasiswa</h1>

<div class="card">
    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>Mahasiswa</th>
            <th>NIM</th>
            <th>Topik</th>
            <th>Status</th>
        </tr>

        <tr>
            <td>Leon Kennedy</td>
            <td>3312401987</td>
            <td>PBL Laravel</td>
            <td>APPROVED</td>
        </tr>
    </table>
</div>

@endsection