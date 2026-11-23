<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visitor extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'visitor';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'ip',
        'date',
        'country',
        'city',
        'state_name',
        'lat',
        'long',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
