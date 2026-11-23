
<?php

$defaultTitle = env(
    'SEO_DEFAULT_TITLE',
    env('APP_NAME', 'Portal DISPUSAKA')
);

$defaultDescription = env(
    'SEO_DEFAULT_DESCRIPTION',
    'Portal informasi berita, layanan, koleksi buku, dan informasi publik DISPUSAKA.'
);

$defaultImage = env('SEO_DEFAULT_IMAGE');

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),

    /*
    |--------------------------------------------------------------------------
    | SEO Meta Tags
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'defaults' => [
            'title' => $defaultTitle,
            'titleBefore' => false,
            'description' => $defaultDescription,
            'separator' => ' | ',
            'keywords' => [],
            'canonical' => 'current',
            'robots' => env('SEO_ROBOTS', 'index,follow'),
        ],

        'webmaster_tags' => [
            'google' => env('GOOGLE_SITE_VERIFICATION'),
            'bing' => env('BING_SITE_VERIFICATION'),
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph
    |--------------------------------------------------------------------------
    */
    'opengraph' => [
        'defaults' => [
            'title' => $defaultTitle,
            'description' => $defaultDescription,
            'url' => null,
            'type' => 'website',
            'site_name' => env('APP_NAME', 'Portal DISPUSAKA'),
            'images' => $defaultImage ? [$defaultImage] : [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Cards
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => env('TWITTER_SITE'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON-LD Structured Data
    |--------------------------------------------------------------------------
    */
    'json-ld' => [
        'defaults' => [
            'title' => $defaultTitle,
            'description' => $defaultDescription,
            'url' => 'current',
            'type' => 'WebPage',
            'images' => $defaultImage ? [$defaultImage] : [],
        ],
    ],
];
