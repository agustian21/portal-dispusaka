<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Pejabat extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pejabats';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'nama',
        'nip',
        'pangkat/gol',
        'jabatan',
        'namabidang_id',
        'status_id',
        'foto',
        'created_by',
        'updated_by',
    ];

    public function namabidang(): BelongsTo
    {
        return $this->belongsTo(Namabidang::class, 'namabidang_id');
    }
}
