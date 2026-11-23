<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kadis extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'kadis';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'nama',
        'jabatan',
        'periode',
        'status_id',
        'foto',
        'created_by',
        'updated_by',
    ];
}
