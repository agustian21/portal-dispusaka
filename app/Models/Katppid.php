<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Katppid extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'katppid';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'nm_ppid',
    ];

    public function ppids(): HasMany
    {
        return $this->hasMany(Ppid::class, 'katppid_id');
    }
}
