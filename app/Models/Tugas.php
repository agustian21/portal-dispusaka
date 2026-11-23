<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Str;

class Tugas extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tugas';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'tugas_fungsi',
        'link_google',
        'created_by',
        'updated_by',
    ];

    protected function safeTugasFungsi(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {

                $raw = trim((string) ($attributes['tugas_fungsi'] ?? ''));

                if ($raw === '') {
                    return '';
                }

                return strip_tags(
                    $raw,
                    '<p><br><strong><b><em><i><ul><ol><li><table><thead><tbody><tr><td>'
                );
            }
        )->shouldCache();
    }

    protected function googleMapExternalUrl(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes): ?string =>
            $this->validatedGoogleMapsUrl(
                $attributes['link_google'] ?? null
            )
        );
    }

    protected function googleMapEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): ?string {
                $url = $this->validatedGoogleMapsUrl(
                    $attributes['link_google'] ?? null
                );

                if ($url === null) {
                    return null;
                }

                $parts = parse_url($url);

                if ($parts === false) {
                    return null;
                }

                $host = strtolower($parts['host'] ?? '');
                $path = $parts['path'] ?? '';

                /*
                 * Preferred official-style Embed API /maps/embed... URL.
                 */
                if (
                    in_array($host, ['google.com', 'www.google.com'], true) &&
                    str_starts_with($path, '/maps/embed')
                ) {
                    return $url;
                }

                /*
                 * Some legacy Google Maps iframe URLs use maps.google.com/maps
                 * together with output=embed.
                 */
                if (
                    $host === 'maps.google.com' &&
                    str_starts_with($path, '/maps')
                ) {
                    parse_str($parts['query'] ?? '', $query);

                    return ($query['output'] ?? null) === 'embed'
                        ? $url
                        : null;
                }

                /*
                 * Ordinary /maps/place/... URLs and maps.app.goo.gl short links
                 * remain available as external links, but not iframe sources.
                 */
                return null;
            }
        );
    }

    private function validatedGoogleMapsUrl(?string $candidate): ?string
    {
        $url = trim((string) $candidate);

        if (
            $url === '' ||
            filter_var($url, FILTER_VALIDATE_URL) === false
        ) {
            return null;
        }

        $parts = parse_url($url);

        if ($parts === false || ($parts['scheme'] ?? null) !== 'https') {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');

        $allowedHosts = [
            'google.com',
            'www.google.com',
            'maps.google.com',
            'maps.app.goo.gl',
        ];

        return in_array($host, $allowedHosts, true)
            ? $url
            : null;
    }
}
