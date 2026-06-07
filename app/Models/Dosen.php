<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = [
        'user_id', 'nama', 'nidn', 'email', 'status',
        'no_hp', 'foto', 'catatan', 'ruangan_id',
    ];

public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}