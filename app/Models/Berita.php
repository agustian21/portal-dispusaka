<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Berita extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'berita';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'judul',
        'slug_judul',
        'tgl',
        'isi',
        'gambar',
        'status_id',
        'description',
        'dibaca',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tgl' => 'date',
        'dibaca' => 'integer',
        'status_id' => 'integer',
    ];
}
