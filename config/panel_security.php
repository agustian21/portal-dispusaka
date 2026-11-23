<?php

return [
    'turnstile' => [
        // Nilai diambil dari .env saat config:cache; jangan hardcode secret di source code.
        'site_key' => env('TURNSTILE_SITE_KEY', ''),
        'secret_key' => env('TURNSTILE_SECRET_KEY', ''),
        'expected_hostname' => env('TURNSTILE_EXPECTED_HOSTNAME', ''),
    ],
];
