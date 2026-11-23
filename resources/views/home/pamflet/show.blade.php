@extends('home.layouts.app')

@php
    $images = collect($pamflet->gambar ?? []);
    $cover = $images->first();

    $plainDescription = trim(
        strip_tags($pamflet->deskripsi ?? '')
    );

    $metaDescription = \Illuminate\Support\Str::limit(
        $plainDescription
        ?: 'Informasi pamflet resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah.',
        160
    );

    $ogImage = $cover
        ? asset('uploads_files/pamflet/' . $cover)
        : asset('assets/images/Logo-Sulteng.png');
@endphp

@section(
    'title',
    $pamflet->nm_pamflet . ' - DISPUSAKA Prov. Sulteng'
)

@section(
    'meta_description',
    $metaDescription
)

@push('meta')
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $pamflet->nm_pamflet }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="DISPUSAKA Sulawesi Tengah">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pamflet->nm_pamflet }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
@endpush

@push('styles')
    @vite('resources/css/pamflet.css')
@endpush

@section('contents')
    <div class="pamflet-page">

        {{-- DETAIL HERO --}}
        <section class="pm-detail-hero" aria-labelledby="pamflet-detail-title">
            <div class="pm-hero-pattern" aria-hidden="true"></div>
            <div class="pm-detail-orb" aria-hidden="true"></div>

            <div class="container">
                <nav class="pm-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>

                    <i class="fa-solid fa-chevron-right pm-breadcrumb-separator" aria-hidden="true"></i>

                    <a href="{{ route('pamflet-dispusaka') }}">
                        Pamflet
                    </a>

                    <i class="fa-solid fa-chevron-right pm-breadcrumb-separator" aria-hidden="true"></i>

                    <span aria-current="page">
                        Detail
                    </span>
                </nav>

                <div class="pm-detail-hero-copy">
                    <span class="pm-hero-eyebrow">
                        <span class="pm-hero-eyebrow-icon" aria-hidden="true">
                            <i class="fa-solid fa-bullhorn"></i>
                        </span>

                        Informasi Resmi DISPUSAKA
                    </span>

                    <h1 id="pamflet-detail-title">
                        {{ $pamflet->nm_pamflet }}
                    </h1>

                    <p>
                        Informasi visual resmi Dinas Perpustakaan dan
                        Kearsipan Provinsi Sulawesi Tengah.
                    </p>
                </div>
            </div>
        </section>

        {{-- DETAIL CONTENT --}}
        <section class="pm-detail-section" aria-label="Detail pamflet">
            <div class="container">
                <div class="pm-detail-shell">

                    {{-- POSTER --}}
                    <div class="pm-detail-media">
                        <div class="pm-detail-poster-frame">
                            @if ($cover)
                                <img src="{{ asset('uploads_files/pamflet/' . $cover) }}"
                                    alt="Pamflet {{ $pamflet->nm_pamflet }}" width="800" height="1000" decoding="async">
                            @else
                                <div class="pm-detail-placeholder">
                                    <span>
                                        <i class="fa-regular fa-image"></i>
                                    </span>

                                    <strong>
                                        Gambar belum tersedia
                                    </strong>

                                    <small>
                                        Informasi dapat tetap dibaca
                                        melalui deskripsi di halaman ini.
                                    </small>
                                </div>
                            @endif
                        </div>

                        @if ($cover)
                            <a href="{{ asset('uploads_files/pamflet/' . $cover) }}" target="_blank" rel="noopener"
                                class="pm-open-image">
                                <i class="fa-solid fa-expand"></i>
                                Buka gambar ukuran penuh
                            </a>
                        @endif
                    </div>

                    {{-- INFORMATION --}}
                    <article class="pm-detail-content">
                        <span class="pm-detail-label">
                            <i class="fa-solid fa-circle-check"></i>
                            Informasi Publik
                        </span>

                        <h2>
                            {{ $pamflet->nm_pamflet }}
                        </h2>

                        <div class="pm-detail-divider"></div>

                        <div class="pm-detail-description">
                            @if ($plainDescription)
                                {{ $plainDescription }}
                            @else
                                Informasi lengkap tersedia pada
                                pamflet yang ditampilkan di halaman ini.
                            @endif
                        </div>

                        <div class="pm-detail-facts">
                            <div class="pm-detail-fact">
                                <span class="pm-detail-fact-icon">
                                    <i class="fa-solid fa-building-columns"></i>
                                </span>

                                <span>
                                    <small>Diterbitkan oleh</small>
                                    <strong>DISPUSAKA Sulawesi Tengah</strong>
                                </span>
                            </div>

                            <div class="pm-detail-fact">
                                <span class="pm-detail-fact-icon">
                                    <i class="fa-regular fa-image"></i>
                                </span>

                                <span>
                                    <small>Format informasi</small>
                                    <strong>Pamflet visual</strong>
                                </span>
                            </div>

                            @if ($images->count() > 1)
                                <div class="pm-detail-fact">
                                    <span class="pm-detail-fact-icon">
                                        <i class="fa-regular fa-images"></i>
                                    </span>

                                    <span>
                                        <small>Jumlah visual</small>
                                        <strong>
                                            {{ $images->count() }} gambar
                                        </strong>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="pm-detail-actions">
                            <a href="{{ route('pamflet-dispusaka') }}" class="pm-button pm-button-primary">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali ke koleksi
                            </a>

                            @if ($cover)
                                <a href="{{ asset('uploads_files/pamflet/' . $cover) }}" target="_blank" rel="noopener"
                                    class="pm-button pm-button-secondary">
                                    <i class="fa-regular fa-image"></i>
                                    Lihat gambar
                                </a>
                            @endif
                        </div>

                        <div class="pm-detail-note">
                            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>

                            <p>
                                Pastikan informasi pada pamflet
                                dibaca secara lengkap sebelum
                                menggunakan jadwal, lokasi,
                                atau ketentuan layanan yang tercantum.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- OTHER IMAGES --}}
        @if ($images->count() > 1)
            <section class="pm-gallery-section" aria-labelledby="pamflet-gallery-title">
                <div class="container">
                    <div class="pm-gallery-heading">
                        <span class="pm-section-eyebrow">
                            <i class="fa-regular fa-images"></i>
                            Visual lainnya
                        </span>

                        <h2 id="pamflet-gallery-title">
                            Gambar pendukung
                        </h2>

                        <p>
                            Informasi tambahan yang menjadi bagian
                            dari pamflet ini.
                        </p>
                    </div>

                    <div class="pm-gallery-grid">
                        @foreach ($images->skip(1) as $index => $image)
                            <a href="{{ asset('uploads_files/pamflet/' . $image) }}" target="_blank" rel="noopener"
                                class="pm-gallery-item">
                                <div class="pm-gallery-poster">
                                    <img src="{{ asset('uploads_files/pamflet/' . $image) }}"
                                        alt="Gambar {{ $index + 2 }} dari pamflet {{ $pamflet->nm_pamflet }}" width="800"
                                        height="1000" loading="lazy" decoding="async">
                                </div>

                                <span>
                                    Gambar {{ $index + 2 }}
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection