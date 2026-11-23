<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Slider extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'slider';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'nm_slide',
        'gambar',
        'status_id',
        'created_by',
        'updated_by',
    ];
}
