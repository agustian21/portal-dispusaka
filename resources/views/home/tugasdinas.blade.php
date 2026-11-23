@extends('home.layouts.app')
@section('title', 'Tugas dan Fungsi - DISPUSAKA Prov. Sulteng')

@section('contents')
    @php
        /*
         * Keep branching defensive. The controller may legitimately return null
         * if no Tugas record has been published.
         */
        $hasData = isset($data) && $data !== null;

        /*
         * Raw content is used only for the SAFE plain-text fallback below.
         * It is never echoed directly as unescaped HTML.
         */
        $rawContent = $hasData ? trim((string) ($data->tugas_fungsi ?? '')) : '';

        /*
         * These computed attributes come from the recommended Tugas model.
         */
        $safeContent = $hasData ? trim((string) ($data->safe_tugas_fungsi ?? '')) : '';

        $mapEmbedUrl = $hasData ? $data->google_map_embed_url ?? null : null;

        $mapExternalUrl = $hasData ? $data->google_map_external_url ?? null : null;

        $googleDriveUrl = $hasData ? $data->link_google ?? null : null;
    @endphp

    @php
        preg_match('/[-\w]{25,}/', $googleDriveUrl, $matches);
        $driveId = $matches[0] ?? null;
    @endphp

    <div class="tf-page">

        {{-- Compact institutional hero --}}
        <section class="history-hero" aria-labelledby="historyPageTitle">
            <div class="history-hero-pattern" aria-hidden="true"></div>
            <div class="container">
                {{-- Breadcrumb --}}
                <nav class="history-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right history-breadcrumb-separator" aria-hidden="true"></i>
                    <span>Profil</span>
                    <i class="fa-solid fa-chevron-right history-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">Tugas dan Fungsi</span>
                </nav>

                <div class="history-hero-grid">
                    {{-- Hero Content --}}
                    <div class="history-hero-content">
                        <div class="history-hero-label">
                            <span class="history-hero-label-icon">
                                <i class="fa-solid fa-landmark" aria-hidden="true"></i>
                            </span>
                            <span>Profil Instansi</span>
                        </div>

                        <h1 id="historyPageTitle">
                            Tugas dan <span>Fungsi</span>DISPUSAKA
                        </h1>

                        <p class="history-hero-description">
                            Informasi mengenai mandat, kewenangan, dan fungsi kelembagaan dalam penyelenggaraan pelayanan
                            publik.
                        </p>

                        <div class="history-hero-actions">
                            <a href="#tugas-dan-fungsi" class="history-primary-button">
                                <span>Baca Tugas dan Fungsi</span>
                                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                            </a>
                            <div class="history-government-mark">
                                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                                <span>
                                    <small>Instansi</small>Pemerintah Provinsi Sulawesi Tengah
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Hero Visual --}}
                    <div class="history-hero-visual" aria-hidden="true">
                        <div class="history-visual-orbit history-orbit-one"></div>
                        <div class="history-visual-orbit history-orbit-two"></div>

                        <div class="history-logo-card">
                            <div class="history-logo-glow"></div>
                            <div class="history-logo-frame">
                                <img src="{{ asset('assets/images/Logo-Sulteng.png') }}" alt="">
                            </div>
                            <div class="history-logo-information">
                                <span>Dinas Perpustakaan dan Kearsipan</span>
                                <strong>Provinsi Sulawesi Tengah</strong>
                            </div>
                        </div>

                        <div class="history-floating-card history-floating-card-one">
                            <span class="history-floating-icon">
                                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                            </span>
                            <span>
                                <small>Bidang</small>Perpustakaan
                            </span>
                        </div>

                        <div class="history-floating-card history-floating-card-two">
                            <span class="history-floating-icon">
                                <i class="fa-solid fa-box-archive" aria-hidden="true"></i>
                            </span>
                            <span>
                                <small>Bidang</small>Kearsipan
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="history-hero-bottom" aria-hidden="true"></div>
        </section>

        <div class="history-context-wrapper">
            <div class="container">
                <div class="history-context-grid">
                    <div class="history-context-item">
                        <div class="history-context-icon">
                            <i class="fa-solid fa-book-bookmark" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span>Perpustakaan</span>
                            <p>Literasi dan layanan informasi masyarakat.</p>
                        </div>
                    </div>

                    <div class="history-context-divider" aria-hidden="true"></div>

                    <div class="history-context-item">
                        <div class="history-context-icon">
                            <i class="fa-solid fa-box-archive" aria-hidden="true"></i>
                        </div>

                        <div>
                            <span>Kearsipan</span>
                            <p>Pengelolaan arsip dan memori organisasi.</p>
                        </div>
                    </div>

                    <div class="history-context-divider" aria-hidden="true"></div>

                    <div class="history-context-item">
                        <div class="history-context-icon">
                            <i class="fa-solid fa-building-columns" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span>Pelayanan Publik</span>
                            <p>Informasi kelembagaan yang terbuka dan mudah diakses.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Primary reading area --}}
        <section class="tf-content-section" id="tugas-dan-fungsi" aria-labelledby="tf-content-title">
            <div class="container">
                <div class="tf-reading-grid">

                    {{-- Main institutional content --}}
                    <article class="tf-card tf-article">
                        <header class="tf-card-header">
                            <span class="tf-card-icon" aria-hidden="true">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </span>

                            <div>
                                <span class="tf-card-kicker">Mandat Organisasi</span>
                                <h2 id="tf-content-title">Tugas dan Fungsi Dinas</h2>
                            </div>
                        </header>

                        @if ($safeContent !== '')
                            <div class="tf-prose">
                                {!! $safeContent !!}
                            </div>
                        @elseif ($rawContent !== '')
                            <div class="tf-prose tf-prose--plain">
                                {!! nl2br(e($rawContent)) !!}
                            </div>
                        @else
                            {{-- Graceful fallback for absent/empty content --}}
                            <div class="tf-empty-state" role="status">
                                <span class="tf-empty-icon" aria-hidden="true">
                                    <i class="fa-regular fa-file-lines"></i>
                                </span>

                                <div>
                                    <h3>Information is not yet available</h3>
                                    <p>
                                        The task and function information has not been published on this page.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <a class="tf-map-link tf-download-link" href="{{ $googleDriveUrl }}" target="_blank"
                            rel="noopener noreferrer">
                            <i class="fa-solid fa-download"></i>
                            <span>Download / Buka File Google Drive</span>
                        </a>
                    </article>

                    {{-- Supporting location information --}}
                    <aside class="tf-sidebar" aria-label="Location information">
                        <section class="tf-card tf-map-card" aria-labelledby="tf-map-title">
                            <header class="tf-map-heading">
                                <span class="tf-card-icon" aria-hidden="true">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>

                                <div>
                                    <span class="tf-card-kicker">Lokasi Dinas</span>
                                    <h2 id="tf-map-title">Visit our office</h2>
                                </div>
                            </header>

                            @if ($mapEmbedUrl)
                                <div class="tf-map-frame">
                                    <iframe src="{{ $mapEmbedUrl }}" title="Google Map showing the office location"
                                        loading="lazy" allowfullscreen
                                        referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                </div>
                            @else
                                <div class="tf-map-placeholder">
                                    <span class="tf-map-placeholder-icon" aria-hidden="true">
                                        <i class="fa-regular fa-map"></i>
                                    </span>
                                    <p>The interactive map is currently unavailable.</p>
                                    @if ($mapExternalUrl)
                                        <small>
                                            The location can still be opened directly in Google Maps.
                                        </small>
                                    @endif
                                </div>
                            @endif

                            @if ($mapExternalUrl)
                                <a class="tf-map-link" href="{{ $mapExternalUrl }}" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                    <span>Open in Google Maps</span>
                                    <span class="sr-only">(opens in a new tab)</span>
                                </a>
                            @endif

                            <noscript>
                                <div class="tf-noscript">
                                    @if ($mapExternalUrl)
                                        <p>
                                            Interactive map features are unavailable without JavaScript.
                                            <a href="{{ $mapExternalUrl }}" rel="noopener noreferrer">
                                                Open the location in Google Maps.
                                            </a>
                                        </p>
                                    @else
                                        <p>Map information is currently unavailable.</p>
                                    @endif
                                </div>
                            </noscript>
                        </section>

                        {{-- Supporting context, without invented model data --}}
                        <section class="tf-card tf-note-card" aria-labelledby="tf-note-title">
                            <span class="tf-note-icon" aria-hidden="true">
                                <i class="fa-solid fa-circle-info"></i>
                            </span>

                            <div>
                                <h2 id="tf-note-title">Institutional information</h2>
                                <p>
                                    This page presents the published task and function information provided by the
                                    institution.
                                </p>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </section>
    </div>
@endsection
