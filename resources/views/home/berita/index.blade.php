@extends('home.layouts.app')

@push('styles')
    @vite('resources/css/berita.css')
@endpush

@section('contents')
    <div class="bp-page">

        {{-- HERO --}}
        <section class="bp-hero" aria-labelledby="bp-page-title">
            <div class="bp-hero-pattern" aria-hidden="true"></div>
            <div class="bp-hero-orb bp-hero-orb-one" aria-hidden="true"></div>
            <div class="bp-hero-orb bp-hero-orb-two" aria-hidden="true"></div>

            <div class="container">
                <nav class="bp-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i><span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right bp-breadcrumb-separator" aria-hidden="true"></i>
                    <span>Informasi</span>
                    <i class="fa-solid fa-chevron-right bp-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">Berita Dispusaka</span>
                </nav>

                <div class="bp-hero-grid">
                    <div class="bp-hero-copy" data-reveal>
                        <span class="bp-hero-eyebrow">
                            <span class="bp-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-regular fa-newspaper"></i>
                            </span>
                            Berita dan Kegiatan
                        </span>
                        <h1 id="bp-page-title">Kegiatan terbaru dari <span>DISPUSAKA</span></h1>
                        <p>
                            Ikuti kegiatan, layanan, gerakan literasi, serta upaya pelestarian arsip dan memori Sulawesi
                            Tengah melalui informasi resmi DISPUSAKA.
                        </p>

                        <div class="bp-hero-trust">
                            <span><i class="fa-solid fa-circle-check"></i>Informasi resmi</span>
                            <span><i class="fa-regular fa-clock"></i>Diperbarui berkala</span>
                        </div>
                    </div>

                    <div class="bp-hero-visual" aria-hidden="true" data-reveal>
                        <div class="bp-visual-ring"></div>
                        <div class="bp-visual-card bp-visual-card-main">
                            <span class="bp-visual-icon">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </span>
                            <small>Ruang Informasi</small>
                            <strong>Literasi, Arsip & Kegiatan Publik</strong>
                            <div class="bp-visual-lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                        <div class="bp-floating-note bp-floating-note-one">
                            <i class="fa-solid fa-book-open"></i>
                            <span>
                                <small>Literasi</small> Untuk semua
                            </span>
                        </div>

                        <div class="bp-floating-note bp-floating-note-two">
                            <i class="fa-solid fa-box-archive"></i>
                            <span>
                                <small>Arsip</small> Ingatan daerah
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- NEWS FEED --}}
        <section class="bp-feed" aria-labelledby="bp-feed-title">
            <div class="container">

                @php
                    $items = $berita->getCollection();
                @endphp


                @if ($items->count())

                    <header class="bp-section-head" data-reveal>
                        <div>
                            <span class="bp-section-kicker">
                                <i class="fa-regular fa-newspaper"></i>
                                Berita
                            </span>

                            <h2 id="bp-feed-title">
                                Berita DISPUSAKA
                            </h2>

                            <p>
                                Informasi kegiatan, layanan, literasi, dan kearsipan DISPUSAKA Sulawesi Tengah.
                            </p>
                        </div>
                    </header>


                    <div class="bp-grid">

                        @foreach ($items as $item)
                            <article class="bp-card" data-reveal
                                style="--reveal-delay: {{ min($loop->index * 55, 275) }}ms">

                                <a href="{{ route('berita-dispusaka.show', $item->slug_judul) }}" class="bp-card-media"
                                    aria-label="Baca {{ $item->judul }}">

                                    @if ($item->gambar)
                                        <img src="{{ asset('uploads_files/berita/' . $item->gambar) }}"
                                            alt="{{ $item->judul }}" loading="lazy" decoding="async">
                                    @else
                                        <div class="bp-image-placeholder" aria-hidden="true">
                                            <i class="fa-regular fa-image"></i>
                                        </div>
                                    @endif


                                    <span class="bp-card-date">
                                        {{ $item->tgl?->translatedFormat('d M Y') }}
                                    </span>

                                </a>


                                <div class="bp-card-body">

                                    <span class="bp-card-category">
                                        <i class="fa-solid fa-circle"></i>
                                        Berita DISPUSAKA
                                    </span>


                                    <h3>
                                        <a href="{{ route('berita-dispusaka.show', $item->slug_judul) }}">
                                            {{ $item->judul }}
                                        </a>
                                    </h3>


                                    @if ($item->description)
                                        <p>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 125) }}
                                        </p>
                                    @endif


                                    <div class="bp-card-footer">

                                        <span>
                                            <i class="fa-regular fa-eye"></i>
                                            {{ number_format($item->dibaca ?? 0) }}
                                        </span>


                                        <a href="{{ route('berita-dispusaka.show', $item->slug_judul) }}"
                                            aria-label="Baca selengkapnya: {{ $item->judul }}">

                                            Baca
                                            <i class="fa-solid fa-arrow-right"></i>

                                        </a>

                                    </div>

                                </div>

                            </article>
                        @endforeach

                    </div>



                    {{-- SIMPLE PAGINATION --}}
                    @if ($berita->previousPageUrl() || $berita->nextPageUrl())
                        <nav class="bp-pager" aria-label="Navigasi halaman berita" data-reveal>


                            @if ($berita->previousPageUrl())
                                <a href="{{ $berita->previousPageUrl() }}" class="bp-pager-link bp-pager-prev">

                                    <span class="bp-pager-icon">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>

                                    <span>
                                        <small>Kembali</small>
                                        Sebelumnya
                                    </span>

                                </a>
                            @else
                                <span class="bp-pager-link bp-pager-prev is-disabled" aria-disabled="true">

                                    <span class="bp-pager-icon">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>

                                    <span>
                                        <small>Kembali</small>
                                        Sebelumnya
                                    </span>

                                </span>
                            @endif



                            @if ($berita->nextPageUrl())
                                <a href="{{ $berita->nextPageUrl() }}" class="bp-pager-link bp-pager-next">

                                    <span>
                                        <small>Lanjutkan</small>
                                        Selanjutnya
                                    </span>

                                    <span class="bp-pager-icon">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>

                                </a>
                            @else
                                <span class="bp-pager-link bp-pager-next is-disabled" aria-disabled="true">

                                    <span>
                                        <small>Lanjutkan</small>
                                        Selanjutnya
                                    </span>

                                    <span class="bp-pager-icon">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>

                                </span>
                            @endif


                        </nav>
                    @endif
                @else
                    <div class="bp-empty" data-reveal>

                        <span class="bp-empty-icon">
                            <i class="fa-regular fa-newspaper"></i>
                        </span>


                        <h2>
                            Belum ada berita yang diterbitkan
                        </h2>


                        <p>
                            Informasi DISPUSAKA akan tampil di halaman ini setelah dipublikasikan.
                        </p>


                        <a href="{{ route('beranda') }}">

                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali ke beranda

                        </a>


                    </div>


                @endif


            </div>
        </section>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/berita.js')
@endpush
