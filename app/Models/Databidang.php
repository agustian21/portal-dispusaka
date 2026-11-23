<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Databidang extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'databidangs';

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'judul',
        'namabidang_id',
        'file',
        'status_id',
        'created_by',
        'updated_by',
    ];

    public function namabidang(): BelongsTo
    {
        return $this->belongsTo(Namabidang::class, 'namabidang_id');
    }
}
