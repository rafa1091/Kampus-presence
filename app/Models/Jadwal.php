<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals'; // ganti ke ini

    protected $fillable = [
        'dosen_id', 'hari', 'mulai', 'selesai', 'aktivitas', 'matakuliah',
    ];
}