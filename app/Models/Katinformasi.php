<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Katinformasi extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'katinformasis';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'nama_katinformasi',
    ];

    public function ppids(): HasMany
    {
        return $this->hasMany(Ppid::class, 'katinformasi_id');
    }
}
