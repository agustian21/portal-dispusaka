<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Alamat extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'alamats';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'nama',
        'singkatan',
        'alamat',
        'email',
        'telepon',
        'link_maps',
        'facebook',
        'instagram',
        'created_by',
        'updated_by',
    ];
}
