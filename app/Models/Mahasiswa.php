<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Jika nama tabelmu di database bukan 'mahasiswas' (jamak), 
    // melainkan 'mahasiswa' (tunggal), definisikan di sini:
    protected $table = 'mahasiswa'; 

    protected $fillable = [
        'user_id',
        'dosen_id',
        // kolom lain milik mahasiswa...
    ];
}