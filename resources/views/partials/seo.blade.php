@php

    // Mengambil alamat halaman saat ini
    $currentPath = '/' . trim(request()->path(), '/');

    if ($currentPath === '') {
        $currentPath = '/';
    }

    // Mengambil pengaturan SEO halaman
    $pages = config('seo.pages', []);

    $pageSeo = $pages[$currentPath] ?? [];

    // Pengaturan default
    $defaults = [
        'title' => config('seo.default_title'),

        'description' => config('seo.default_description'),

        'image' => config('seo.default_image'),

        'robots' => 'index,follow,max-image-preview:large',

        'type' => 'website',

        'canonical' => request()->url(),
    ];

    // SEO dari controller dapat menggantikan pengaturan default
    $seoOverrides = isset($seo) && is_array($seo) ? $seo : [];

    $seoData = array_replace($defaults, $pageSeo, $seoOverrides);

    $title = $seoData['title'];

    $description = trim(preg_replace('/\s+/', ' ', strip_tags($seoData['description'])));

    $image = $seoData['image'];

    $imageUrl = preg_match('/^https?:\/\//i', $image) ? $image : asset(ltrim($image, '/'));

    $canonical = $seoData['canonical'];

@endphp

{{-- SEO Utama --}}
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $seoData['robots'] }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="author" content="Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah">
<meta name="language" content="id-ID">
{{-- Open Graph --}}
<meta property="og:locale" content="id_ID">
<meta property="og:type" content="{{ $seoData['type'] }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $imageUrl }}">

{{-- Metadata Berita --}}

@if (!empty($seoData['published_time']))
    <meta property="article:published_time" content="{{ $seoData['published_time'] }}">
@endif

@if (!empty($seoData['modified_time']))
    <meta property="article:modified_time" content="{{ $seoData['modified_time'] }}">
@endif
