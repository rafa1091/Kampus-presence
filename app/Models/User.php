<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'nim/nidn',  // Tambahkan ini
    'no_hp',     // Tambahkan ini
    'role',      // Tambahkan ini
];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}