<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Struktur extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'strukturs';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'gambar',
        'created_by',
        'updated_by',
    ];
}
