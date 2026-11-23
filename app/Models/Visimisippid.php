<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visimisippid extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'visimisippids';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'visi',
        'misi',
        'created_by',
        'updated_by',
    ];
}
