<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tugasppid extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tugasppids';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'tugasutama',
        'tugaspelaksana',
        'created_by',
        'updated_by',
    ];
}
