<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Ppid extends Model
{

    use HasFactory, Notifiable;

    protected $table = 'ppids';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'katppid_id',
        'judul',
        'katinformasi_id',
        'file',
        'tahun',
        'status_id',
        'created_by',
        'updated_by',
    ];

    /**
     * Relasi PPID ke kategori PPID.
     */
    public function katppid(): BelongsTo
    {
        return $this->belongsTo(Katppid::class, 'katppid_id');
    }

    /**
     * Relasi PPID ke kategori informasi.
     */
    public function katinformasi(): BelongsTo
    {
        return $this->belongsTo(Katinformasi::class, 'katinformasi_id');
    }
}
