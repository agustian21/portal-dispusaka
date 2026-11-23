<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pamflet extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pamflet';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'nm_pamflet',
        'slug_pamflet',
        'deskripsi',
        'gambar',
        'status_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'gambar'    => 'array',
        'status_id' => 'integer',
    ];

    /**
     * Normalisasi file gambar pamflet.
     *
     * Mendukung:
     * [
     *     "pamflet-1.jpg",
     *     "pamflet-2.jpg"
     * ]
     *
     * dan format array object sederhana seperti:
     * [
     *     ["name" => "pamflet-1.jpg"]
     * ]
     */
    public function getImageFilesAttribute(): array
    {
        $images = is_array($this->gambar)
            ? $this->gambar
            : [];

        return collect($images)
            ->map(function ($image) {
                if (is_string($image)) {
                    return basename($image);
                }

                if (is_array($image)) {
                    $file = $image['name']
                        ?? $image['filename']
                        ?? $image['file']
                        ?? $image['path']
                        ?? null;

                    return is_string($file)
                        ? basename($file)
                        : null;
                }

                return null;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
