<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'video';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'linkvideo',
        'judul',
        'tglupload',
        'status_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tglupload' => 'date',
    ];

    /**
     * Hanya mengizinkan URL YouTube embed HTTPS.
     * Query string dari database tidak diteruskan.
     */
    public static function extractYoutubeId(?string $value): ?string
    {
        $url = trim((string) $value);

        if ($url === '') {
            return null;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $parts = parse_url($url);

        if (! is_array($parts)) {
            return null;
        }

        $scheme = strtolower($parts['scheme'] ?? '');
        $host = strtolower($parts['host'] ?? '');
        $path = $parts['path'] ?? '';

        if ($scheme !== 'https') {
            return null;
        }

        $allowedHosts = [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com',
        ];

        if (! in_array($host, $allowedHosts, true)) {
            return null;
        }

        if (! preg_match(
            '~^/embed/([A-Za-z0-9_-]{11})/?$~',
            $path,
            $matches
        )) {
            return null;
        }

        return $matches[1];
    }

    public function getYoutubeIdAttribute(): ?string
    {
        return self::extractYoutubeId($this->linkvideo);
    }
}
