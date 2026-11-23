<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Namabidang extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'namabidangs';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'nama_bidang',
        'deskripsi',
        'status_id',
        'created_by',
        'updated_by',
    ];

    public function ppids(): HasMany
    {
        return $this->hasMany(Databidang::class, 'namabidang_id');
    }
}
