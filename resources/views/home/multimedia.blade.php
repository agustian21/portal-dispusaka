@extends('home.layouts.app')

@section('title', 'Koleksi Video - DISPUSAKA Sulawesi Tengah')

@section(
    'meta_description',
    'Koleksi video resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah. Dokumentasi kegiatan, literasi, layanan perpustakaan, dan kearsipan.'
)

@push('styles')
    @vite('resources/css/multimedia.css')
@endpush

@section('contents')
    <div class="video-page">

        {{-- HERO --}}
        <section class="video-hero" aria-labelledby="video-page-title">
            <div class="video-hero-pattern" aria-hidden="true"></div>
            <div class="video-hero-orb video-hero-orb-one" aria-hidden="true"></div>
            <div class="video-hero-orb video-hero-orb-two" aria-hidden="true"></div>

            <div class="container">
                <nav class="video-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>

                    <i class="fa-solid fa-chevron-right video-breadcrumb-separator" aria-hidden="true"></i>

                    <span>Informasi</span>

                    <i class="fa-solid fa-chevron-right video-breadcrumb-separator" aria-hidden="true"></i>

                    <span aria-current="page">Koleksi Video</span>
                </nav>

                <div class="video-hero-grid">
                    <div class="video-hero-copy">
                        <span class="video-hero-eyebrow">
                            <span class="video-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-solid fa-circle-play"></i>
                            </span>

                            Koleksi Video DISPUSAKA
                        </span>

                        <h1 id="video-page-title">
                            Lihat kegiatan DISPUSAKA
                            <span>lebih dekat</span>
                        </h1>

                        <p>
                            Saksikan dokumentasi kegiatan, layanan perpustakaan,
                            gerakan literasi, pelestarian arsip, dan aktivitas
                            publik DISPUSAKA Sulawesi Tengah.
                        </p>

                        <div class="video-hero-trust" aria-label="Informasi koleksi">
                            <span>
                                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                Video resmi DISPUSAKA
                            </span>

                            <span>
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                Diperbarui berkala
                            </span>
                        </div>
                    </div>

                    <div class="video-hero-visual" aria-hidden="true">
                        <div class="video-visual-ring"></div>

                        <div class="video-visual-player">
                            <span class="video-visual-badge">
                                Dokumentasi Publik
                            </span>

                            <span class="video-visual-play">
                                <i class="fa-solid fa-play"></i>
                            </span>

                            <div class="video-visual-copy">
                                <small>Ruang Audiovisual</small>
                                <strong>Literasi, arsip & kegiatan publik</strong>
                            </div>
                        </div>

                        <div class="video-floating-card video-floating-card-one">
                            <i class="fa-solid fa-book-open"></i>
                            <span>
                                <small>Literasi</small>
                                Untuk semua
                            </span>
                        </div>

                        <div class="video-floating-card video-floating-card-two">
                            <i class="fa-solid fa-box-archive"></i>
                            <span>
                                <small>Arsip</small>
                                Memori daerah
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- GALLERY --}}
        <section class="video-gallery-section" aria-labelledby="video-gallery-heading">
            <div class="container">

                <header class="video-section-head">
                    <div>
                        <span class="video-section-eyebrow">
                            <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                            Audiovisual
                        </span>

                        <h2 id="video-gallery-heading">
                            Video terbaru
                        </h2>

                        <p>
                            Pilih video untuk menontonnya langsung tanpa
                            meninggalkan halaman koleksi.
                        </p>
                    </div>

                    <div class="video-section-note">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        <span>
                            Klik kartu untuk
                            <strong>memutar video</strong>
                        </span>
                    </div>
                </header>

                @if ($video->count())
                    <div class="video-gallery">
                        @foreach ($video as $item)
                            @php
                                $youtubeId = $item->youtube_id;

                                // Fallback praktis.
                                // Jangka panjang sebaiknya simpan thumbnail_url
                                // dari YouTube Data API ketika admin menyimpan video.
                                $thumbnail = $youtubeId
                                    ? "https://i.ytimg.com/vi/{$youtubeId}/hqdefault.jpg"
                                    : null;
                            @endphp

                            @if ($youtubeId)
                                <article class="video-gallery-card">
                                    <button type="button" class="video-card-trigger" data-video-trigger data-video-id="{{ $youtubeId }}"
                                        data-video-title="{{ $item->judul }}" aria-haspopup="dialog" aria-controls="videoModal"
                                        aria-label="Putar video: {{ $item->judul }}">
                                        <span class="video-card-media">
                                            <img src="{{ $thumbnail }}" alt="" width="480" height="270" loading="lazy" decoding="async">

                                            <span class="video-card-gradient" aria-hidden="true"></span>

                                            <span class="video-card-play" aria-hidden="true">
                                                <i class="fa-solid fa-play"></i>
                                            </span>

                                            <span class="video-card-type" aria-hidden="true">
                                                <i class="fa-brands fa-youtube"></i>
                                                Video
                                            </span>
                                        </span>

                                        <span class="video-card-body">
                                            <span class="video-card-meta">
                                                @if ($item->tglupload)
                                                    <time datetime="{{ $item->tglupload->format('Y-m-d') }}">
                                                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>

                                                        {{ $item->tglupload->format('d/m/Y') }}
                                                    </time>
                                                @endif

                                                <span>
                                                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                                    DISPUSAKA
                                                </span>
                                            </span>

                                            <strong class="video-card-title">
                                                {{ $item->judul }}
                                            </strong>

                                            <span class="video-card-action">
                                                Tonton video

                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </button>
                                </article>
                            @endif
                        @endforeach
                    </div>

                    {{-- SIMPLE PAGINATION --}}
                    @if ($video->previousPageUrl() || $video->nextPageUrl())
                        <nav class="bp-pager" aria-label="Navigasi halaman koleksi video" data-reveal>
                            {{-- PREVIOUS --}}
                            @if ($video->previousPageUrl())
                                <a href="{{ $video->previousPageUrl() }}" class="bp-pager-link bp-pager-prev" rel="prev"
                                    aria-label="Buka halaman video sebelumnya">

                                    <span class="bp-pager-icon" aria-hidden="true">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>
                                    <span class="bp-pager-content">
                                        <small>Kembali</small>
                                        <strong>Sebelumnya</strong>
                                    </span>
                                </a>
                            @else
                                <span class="bp-pager-link bp-pager-prev is-disabled" aria-disabled="true">

                                    <span class="bp-pager-icon" aria-hidden="true">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>
                                    <span class="bp-pager-content">
                                        <small>Kembali</small>
                                        <strong>Sebelumnya</strong>
                                    </span>
                                </span>
                            @endif

                            {{-- NEXT --}}
                            @if ($video->nextPageUrl())
                                <a href="{{ $video->nextPageUrl() }}" class="bp-pager-link bp-pager-next" rel="next"
                                    aria-label="Buka halaman video selanjutnya">
                                    <span class="bp-pager-content">
                                        <small>Lanjutkan</small>
                                        <strong>Selanjutnya</strong>
                                    </span>
                                    <span class="bp-pager-icon" aria-hidden="true">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </a>
                            @else
                                <span class="bp-pager-link bp-pager-next is-disabled" aria-disabled="true">
                                    <span class="bp-pager-content">
                                        <small>Lanjutkan</small>
                                        <strong>Selanjutnya</strong>
                                    </span>
                                    <span class="bp-pager-icon" aria-hidden="true">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </span>
                            @endif
                        </nav>
                    @endif

                @else
                    <div class="video-empty-state" data-reveal>
                        <span class="video-empty-icon" aria-hidden="true">
                            <i class="fa-solid fa-video-slash"></i>
                        </span>
                        <div>
                            <h2>Belum ada video yang ditampilkan</h2>
                            <p>
                                Koleksi video resmi DISPUSAKA akan tampil di halaman ini setelah tersedia.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        {{-- MODAL --}}
        <div id="videoModal" class="video-modal" role="dialog" aria-modal="true" aria-labelledby="videoModalTitle" hidden>
            <div class="video-modal-backdrop" data-modal-backdrop aria-hidden="true"></div>

            <div class="video-modal-panel" data-modal-panel>
                <header class="video-modal-header">
                    <div class="video-modal-heading">
                        <span>
                            <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                            Sedang diputar
                        </span>

                        <h2 id="videoModalTitle">
                            Video DISPUSAKA
                        </h2>
                    </div>

                    <button type="button" class="video-modal-close" data-modal-close aria-label="Tutup video">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </header>

                <div class="video-player-wrap">
                    <div id="youtubePlayerHost" class="video-player-host"></div>
                </div>

                <p id="videoAutoplayNotice" class="video-autoplay-notice" hidden>
                    Autoplay diblokir oleh browser. Tekan tombol putar pada
                    player untuk memulai video.
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/multimedia.js')
@endpush
