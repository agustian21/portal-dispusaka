@extends('home.layouts.app')

@section('title', 'Pamflet dan Pengumuman - DISPUSAKA Prov. Sulteng')

@section(
    'meta_description',
    'Koleksi pamflet dan pengumuman resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah. Temukan informasi kegiatan, layanan, literasi, kearsipan, dan informasi publik terbaru.'
)

@push('styles')
    @vite('resources/css/pamflet.css')
@endpush

@section('contents')
    <div class="pamflet-page">

        {{-- HERO --}}
        <section class="pamflet-hero" aria-labelledby="pamflet-page-title">
            <div class="pm-hero-pattern" aria-hidden="true"></div>
            <div class="pm-hero-orb pm-hero-orb-one" aria-hidden="true"></div>
            <div class="pm-hero-orb pm-hero-orb-two" aria-hidden="true"></div>

            <div class="container">
                <nav class="pm-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right pm-breadcrumb-separator" aria-hidden="true"></i>
                    <span>Informasi</span>
                    <i class="fa-solid fa-chevron-right pm-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">Pamflet</span>
                </nav>

                <div class="pm-hero-grid">
                    <div class="pm-hero-copy">
                        <span class="pm-hero-eyebrow">
                            <span class="pm-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-regular fa-images"></i>
                            </span>
                            Informasi Visual DISPUSAKA
                        </span>

                        <h1 id="pamflet-page-title">
                            Informasi publik
                            <span>lebih mudah ditemukan</span>
                        </h1>

                        <p>
                            Temukan pamflet, agenda, pengumuman, dan informasi
                            layanan DISPUSAKA Sulawesi Tengah dalam satu ruang
                            visual yang ringkas dan nyaman dibaca.
                        </p>

                        <div class="pm-hero-points" aria-label="Informasi koleksi">
                            <span>
                                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                Informasi resmi
                            </span>

                            <span>
                                <i class="fa-regular fa-image" aria-hidden="true"></i>
                                Format visual 4:5
                            </span>

                            <span>
                                <i class="fa-solid fa-arrow-pointer" aria-hidden="true"></i>
                                Buka detail dengan mudah
                            </span>
                        </div>
                    </div>

                    <div class="pm-hero-visual" aria-hidden="true">
                        <div class="pm-visual-ring"></div>

                        <div class="pm-visual-sheet pm-visual-sheet-back">
                            <span class="pm-mini-line pm-mini-line-short"></span>
                            <span class="pm-mini-line"></span>
                            <span class="pm-mini-line"></span>
                        </div>

                        <div class="pm-visual-sheet pm-visual-sheet-middle">
                            <span class="pm-mini-line pm-mini-line-short"></span>
                            <span class="pm-mini-line"></span>
                            <span class="pm-mini-line"></span>
                        </div>

                        <div class="pm-visual-sheet pm-visual-sheet-main">
                            <div class="pm-visual-sheet-top">
                                <span>Informasi Publik</span>

                                <i class="fa-solid fa-bullhorn"></i>
                            </div>

                            <div class="pm-visual-sheet-icon">
                                <i class="fa-regular fa-image"></i>
                            </div>

                            <div class="pm-visual-sheet-copy">
                                <small>DISPUSAKA Sulteng</small>
                                <strong>Pamflet & Pengumuman</strong>
                            </div>
                        </div>

                        <div class="pm-floating-note pm-floating-note-one">
                            <i class="fa-solid fa-book-open"></i>

                            <span>
                                <small>Literasi</small>
                                Informasi kegiatan
                            </span>
                        </div>

                        <div class="pm-floating-note pm-floating-note-two">
                            <i class="fa-solid fa-bell"></i>

                            <span>
                                <small>Pengumuman</small>
                                Layanan publik
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- COLLECTION --}}
        <section class="pm-collection-section" aria-labelledby="pamflet-collection-title">
            <div class="container">
                <div class="pm-section-heading">
                    <div>
                        <span class="pm-section-eyebrow">
                            <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                            Koleksi DISPUSAKA
                        </span>

                        <h2 id="pamflet-collection-title">
                            Pamflet dan pengumuman
                        </h2>

                        <p>
                            Pilih informasi yang ingin Anda lihat.
                            Setiap pamflet memiliki halaman detail sendiri.
                        </p>
                    </div>

                    <div class="pm-section-info" aria-label="Tampilan halaman">
                        <span class="pm-section-info-icon" aria-hidden="true">
                            <i class="fa-solid fa-grip"></i>
                        </span>

                        <span>
                            <small>Tampilan koleksi</small>
                            Maksimal 9 item per halaman
                        </span>
                    </div>
                </div>

                @if ($pamflet->count())
                    <div class="pm-grid">
                        @foreach ($pamflet as $item)
                                @php
                                    $cover = collect($item->gambar ?? [])->first();

                                    $plainDescription = trim(
                                        strip_tags($item->deskripsi ?? '')
                                    );
                                @endphp

                                <article class="pm-card">
                                    <a href="{{ route('pamflet-dispusaka.show', ['pamflet' => $item->slug_pamflet]) }}"
                                        class="pm-card-poster-link">
                                        <div class="pm-card-poster">
                                            @if ($cover)
                                                <img src="{{ asset('uploads_files/pamflet/' . $cover) }}"
                                                    alt="Pamflet {{ $item->nm_pamflet }}" width="800" height="1000" loading="lazy"
                                                    decoding="async">
                                            @else
                                                <div class="pm-card-placeholder">
                                                    <span>
                                                        <i class="fa-regular fa-image"></i>
                                                    </span>

                                                    <small>Gambar belum tersedia</small>
                                                </div>
                                            @endif
                                        </div>

                                        <span class="pm-card-view">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            Lihat detail
                                        </span>
                                    </a>

                                    <div class="pm-card-body">
                                        <span class="pm-card-label">
                                            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                                            Informasi Publik
                                        </span>

                                        <h3>
                                            <a href="{{ route('pamflet-dispusaka.show', ['pamflet' => $item->slug_pamflet]) }}">
                                                {{ $item->nm_pamflet }}
                                            </a>
                                        </h3>

                                        <p>
                                            {{ $plainDescription
                            ? \Illuminate\Support\Str::limit($plainDescription, 125)
                            : 'Lihat informasi lengkap pada halaman detail pamflet DISPUSAKA Sulawesi Tengah.' }}
                                        </p>

                                        <div class="pm-card-footer">
                                            <a href="{{ route('pamflet-dispusaka.show', ['pamflet' => $item->slug_pamflet]) }}">
                                                Buka pamflet
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </a>

                                            @if (count($item->image_files) > 1)
                                                <span>
                                                    <i class="fa-regular fa-images"></i>
                                                    {{ count($item->image_files) }} gambar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                        @endforeach
                    </div>

                    {{-- SIMPLE PAGINATION --}}
                    @if ($pamflet->previousPageUrl() || $pamflet->nextPageUrl())
                        <nav class="pm-pager" aria-label="Navigasi halaman pamflet">
                            @if ($pamflet->previousPageUrl())
                                <a href="{{ $pamflet->previousPageUrl() }}" class="pm-pager-link pm-pager-prev">
                                    <span class="pm-pager-icon">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>

                                    <span>
                                        <small>Kembali</small>
                                        Sebelumnya
                                    </span>
                                </a>
                            @else
                                <span class="pm-pager-link pm-pager-prev is-disabled" aria-disabled="true">
                                    <span class="pm-pager-icon">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </span>

                                    <span>
                                        <small>Kembali</small>
                                        Sebelumnya
                                    </span>
                                </span>
                            @endif

                            @if ($pamflet->nextPageUrl())
                                <a href="{{ $pamflet->nextPageUrl() }}" class="pm-pager-link pm-pager-next">
                                    <span>
                                        <small>Lanjutkan</small>
                                        Selanjutnya
                                    </span>

                                    <span class="pm-pager-icon">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </a>
                            @else
                                <span class="pm-pager-link pm-pager-next is-disabled" aria-disabled="true">
                                    <span>
                                        <small>Lanjutkan</small>
                                        Selanjutnya
                                    </span>

                                    <span class="pm-pager-icon">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </span>
                            @endif
                        </nav>
                    @endif
                @else
                    <div class="pm-empty">
                        <span class="pm-empty-icon">
                            <i class="fa-regular fa-images"></i>
                        </span>

                        <span class="pm-empty-label">
                            Koleksi belum tersedia
                        </span>

                        <h2>
                            Belum ada pamflet yang diterbitkan
                        </h2>

                        <p>
                            Pamflet dan pengumuman resmi DISPUSAKA
                            akan tampil di halaman ini setelah dipublikasikan.
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