<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Faqlayanan extends Model
{
    use HasFactory, Notifiable;
    public const int STATUS_ACTIVE = 1;
    protected $table = 'faqlayanans';
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'judul',
        'isi',
        'status_id',
        'created_by',
        'updated_by',
    ];

    #[Scope]
    protected function aktif(Builder $query): void
    {
        $query->where('status_id', self::STATUS_ACTIVE);
    }
}
