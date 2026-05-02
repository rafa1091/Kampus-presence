<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Bimbingan extends Model
{
    protected $table = 'bimbingan';
 
    protected $fillable = [
        'user_id',
        'dosen_id',
        'tanggal',
        'jam',
        'topik',
        'catatan',
        'status',
        'catatan_dosen',
    ];
 
    protected $casts = [
        'tanggal' => 'date',
    ];
 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
 