@extends('home.layouts.app')

@push('meta')
    @php
        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($berita->description ?: $berita->isi), 160);

        $ogImage = $berita->gambar
            ? asset('uploads_files/berita/' . $berita->gambar)
            : asset('assets/images/Logo-Sulteng.png');
    @endphp

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="DISPUSAKA Sulawesi Tengah">

    @if ($berita->tgl)
        <meta property="article:published_time" content="{{ $berita->tgl->toAtomString() }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $berita->judul }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
@endpush

@push('styles')
    @vite('resources/css/berita.css')
@endpush

@section('contents')
    @php
        $shareUrl = rawurlencode(request()->fullUrl());
        $shareText = rawurlencode($berita->judul . ' | DISPUSAKA Sulawesi Tengah');
    @endphp

    <div class="bd-page">

        {{-- READING PROGRESS --}}
        <div class="bd-reading-progress" aria-hidden="true">
            <span id="readingProgress"></span>
        </div>

        {{-- HERO --}}
        <section class="bd-hero" aria-labelledby="bd-title">
            <div class="bd-hero-pattern" aria-hidden="true"></div>
            <div class="bd-hero-glow" aria-hidden="true"></div>

            <div class="container">
                <nav class="bd-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}"><i class="fa-solid fa-house"></i>Beranda</a>
                    <i class="fa-solid fa-chevron-right bd-breadcrumb-separator" aria-hidden="true"></i>
                    <a href="{{ route('berita-dispusaka') }}">Berita</a>
                    <i class="fa-solid fa-chevron-right bd-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">
                        {{ \Illuminate\Support\Str::limit($berita->judul, 46) }}
                    </span>
                </nav>

                <div class="bd-hero-content" data-reveal>
                    <span class="bd-article-label"><i class="fa-solid fa-circle"></i>Berita DISPUSAKA</span>
                    <h1 id="bd-title">{{ $berita->judul }}</h1>
                    @if ($berita->description)
                        <p class="bd-hero-description">{{ $berita->description }}</p>
                    @endif

                    <div class="bd-hero-meta">
                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            <time datetime="{{ $berita->tgl?->format('Y-m-d') }}">
                                {{ $berita->tgl?->translatedFormat('d F Y') }}
                            </time>
                        </span>
                        <span>
                            <i class="fa-regular fa-eye"></i>
                            {{ number_format($berita->dibaca ?? 0) }} kali dibaca
                        </span>
                        <span>
                            <i class="fa-solid fa-building-columns"></i>
                            DISPUSAKA Sulteng
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- COVER --}}
        <div class="container bd-cover-wrap">
            <figure class="bd-cover" data-reveal>
                @if ($berita->gambar)
                    <img src="{{ asset('uploads_files/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                        loading="eager" fetchpriority="high" decoding="async">
                @else
                    <div class="bd-cover-placeholder" aria-hidden="true">
                        <i class="fa-regular fa-image"></i>
                        <span>Dokumentasi berita DISPUSAKA</span>
                    </div>
                @endif
            </figure>
        </div>

        {{-- ARTICLE AREA --}}
        <section class="bd-content-section">
            <div class="container bd-layout">

                {{-- SHARE RAIL --}}
                <aside class="bd-share-rail" aria-label="Bagikan berita">
                    <div class="bd-share-sticky">
                        <span class="bd-share-title">Bagikan</span>

                        <button type="button" class="bd-share-button bd-share-main" data-share-native
                            aria-label="Bagikan berita" title="Bagikan">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>

                        <a class="bd-share-button" href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}"
                            target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke WhatsApp" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <a class="bd-share-button" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                            target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke Facebook" title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a class="bd-share-button"
                            href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}"
                            target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke X" title="X">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <button type="button" class="bd-share-button" data-copy-link aria-label="Salin tautan berita"
                            title="Salin tautan">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </aside>

                {{-- ARTICLE --}}
                <article class="bd-article" data-article data-reveal>
                    <header class="bd-article-header">
                        <div class="bd-source">
                            <span class="bd-source-logo">
                                <img src="{{ asset('assets/images/Logo-Sulteng.png') }}" alt="">
                            </span>

                            <div>
                                <small>Diterbitkan oleh</small>
                                <strong>DISPUSAKA Sulawesi Tengah</strong>
                            </div>
                        </div>

                        <span class="bd-official-badge">
                            <i class="fa-solid fa-circle-check"></i>
                            Informasi Resmi
                        </span>
                    </header>

                    <div class="bd-prose">
                        {!! $berita->isi !!}
                    </div>

                    <footer class="bd-article-footer">
                        <div>
                            <span class="bd-footer-icon">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </span>

                            <div>
                                <strong>Bagikan informasi yang bermanfaat</strong>
                                <p>
                                    Bantu informasi DISPUSAKA menjangkau lebih banyak
                                    masyarakat Sulawesi Tengah.
                                </p>
                            </div>
                        </div>

                        <button type="button" class="bd-footer-share" data-share-native>
                            <i class="fa-solid fa-share-nodes"></i>
                            Bagikan berita
                        </button>
                    </footer>
                </article>

                {{-- SIDEBAR --}}
                <aside class="bd-sidebar" aria-label="Berita lainnya">
                    <div class="bd-sidebar-card" data-reveal>
                        <div class="bd-sidebar-heading">
                            <span>
                                <i class="fa-regular fa-newspaper"></i>
                                Pilihan lainnya
                            </span>

                            <h2>Berita terbaru</h2>
                        </div>

                        <div class="bd-latest-list">
                            @foreach ($beritaLainnya as $item)
                                <a href="{{ route('berita-dispusaka.show', $item->slug_judul) }}" class="bd-latest-item">
                                    <span class="bd-latest-thumb">
                                        @if ($item->gambar)
                                            <img src="{{ asset('uploads_files/berita/' . $item->gambar) }}"
                                                alt="" loading="lazy" decoding="async">
                                        @else
                                            <span class="bd-mini-placeholder"><i class="fa-regular fa-image"></i></span>
                                        @endif
                                    </span>

                                    <span class="bd-latest-copy">
                                        <small>{{ $item->tgl?->translatedFormat('d M Y') }}</small>
                                        <strong>
                                            {{ \Illuminate\Support\Str::limit($item->judul, 72) }}
                                        </strong>
                                        <span>
                                            <i class="fa-regular fa-eye"></i>{{ number_format($item->dibaca ?? 0) }}
                                        </span>
                                    </span>
                                </a>
                            @endforeach
                        </div>

                        <a href="{{ route('berita-dispusaka') }}" class="bd-sidebar-all">
                            Lihat semua berita
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="bd-sidebar-info" data-reveal>
                        <span class="bd-sidebar-info-icon">
                            <i class="fa-solid fa-landmark"></i>
                        </span>

                        <div>
                            <small>Portal Resmi</small>
                            <strong>DISPUSAKA Sulawesi Tengah</strong>
                            <p>
                                Informasi perpustakaan, kearsipan, literasi, dan layanan publik.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>

            {{-- PREVIOUS NEXT ARTICLE --}}
            @if ($beritaSebelumnya || $beritaSelanjutnya)
                <div class="container">
                    <nav class="bd-article-navigation" aria-label="Navigasi berita" data-reveal>
                        @if ($beritaSebelumnya)
                            <a href="{{ route('berita-dispusaka.show', $beritaSebelumnya->slug_judul) }}"
                                class="bd-nav-article bd-nav-previous">
                                <span class="bd-nav-arrow">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </span>

                                <span class="bd-nav-copy">
                                    <small>Sebelumnya</small>
                                    <strong>
                                        {{ \Illuminate\Support\Str::limit($beritaSebelumnya->judul, 75) }}
                                    </strong>
                                </span>
                            </a>
                        @else
                            <div class="bd-nav-article bd-nav-previous is-empty" aria-hidden="true"></div>
                        @endif

                        @if ($beritaSelanjutnya)
                            <a href="{{ route('berita-dispusaka.show', $beritaSelanjutnya->slug_judul) }}"
                                class="bd-nav-article bd-nav-next">
                                <span class="bd-nav-copy">
                                    <small>Selanjutnya</small>
                                    <strong>
                                        {{ \Illuminate\Support\Str::limit($beritaSelanjutnya->judul, 75) }}
                                    </strong>
                                </span>

                                <span class="bd-nav-arrow">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </a>
                        @else
                            <div class="bd-nav-article bd-nav-next is-empty" aria-hidden="true"></div>
                        @endif
                    </nav>
                </div>
            @endif
        </section>

        <div class="bd-toast" data-share-toast role="status" aria-live="polite" aria-atomic="true"></div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/berita.js')
@endpush
