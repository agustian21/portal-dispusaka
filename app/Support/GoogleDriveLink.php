<?php

namespace App\Support;

final class GoogleDriveLink
{
    /**
     * Normalisasi tautan file Google, bukan folder atau HTML embed.
     * Tidak melakukan request jaringan dan tidak mengubah izin file.
     *
     * @return array{preview: string, open: string}|null
     */
    public static function from(?string $value): ?array
    {
        $value = trim($value ?? '');

        if ($value === '' || preg_match('/[\x00-\x20\x7F\\\\]/', $value)) {
            return null;
        }

        $url = parse_url($value);

        if ($url === false
            || strtolower($url['scheme'] ?? '') !== 'https'
            || isset($url['user']) || isset($url['pass'])
            || (isset($url['port']) && $url['port'] !== 443)) {
            return null;
        }

        $host = strtolower($url['host'] ?? '');
        $path = $url['path'] ?? '';
        parse_str($url['query'] ?? '', $query);
        $id = null;

        if ($host === 'drive.google.com') {
            if (preg_match('~^/file/(?:u/\d+/)?d/([A-Za-z0-9_-]+)(?:/(?:view|preview|edit))?/?$~D', $path, $match)) {
                $id = $match[1];
            } elseif (in_array(rtrim($path, '/'), ['/open', '/uc'], true)) {
                $id = $query['id'] ?? null;
            }
        } elseif ($host === 'docs.google.com') {
            // Tautan dokumen asli. Tautan publish /d/e/... tidak diperlakukan sebagai ID file.
            if (preg_match('~^/(document|spreadsheets|presentation)/(?:u/\d+/)?d/([A-Za-z0-9_-]+)(?:/(?:edit|view|preview))?/?$~D', $path, $match)) {
                $id = $match[2];
            }
        }

        if (! is_string($id) || ! preg_match('/^[A-Za-z0-9_-]+$/D', $id)) {
            return null;
        }

        // Resource key dibutuhkan oleh sebagian tautan yang dibagikan Google.
        $resourceKey = $query['resourcekey'] ?? null;
        $suffix = is_string($resourceKey) && preg_match('/^[A-Za-z0-9_-]+$/D', $resourceKey)
            ? '?'.http_build_query(['resourcekey' => $resourceKey], '', '&', PHP_QUERY_RFC3986)
            : '';
        $base = 'https://drive.google.com/file/d/'.$id;

        return [
            'preview' => $base.'/preview'.$suffix,
            'open' => $base.'/view'.$suffix,
        ];
    }
}
