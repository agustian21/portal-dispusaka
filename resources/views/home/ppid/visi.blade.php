@extends('home.layouts.app')
@section('title', 'Visi dan Misi PPID - Dispusaka Prov. Sulteng')

@push('styles')
    @vite('resources/css/visimisi.css')
@endpush

@section('contents')
    <div class="vm-page">

        {{-- ======================================================
        HERO
        ======================================================= --}}
        <section class="vm-hero" aria-labelledby="vm-hero-title">
            <div class="vm-hero-pattern" aria-hidden="true"></div>

            <div class="vm-orb vm-orb-one" aria-hidden="true"></div>
            <div class="vm-orb vm-orb-two" aria-hidden="true"></div>

            <div class="container">

                {{-- Breadcrumb --}}
                <nav class="vm-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>

                    <i class="fa-solid fa-chevron-right vm-breadcrumb-separator" aria-hidden="true"></i>

                    <span>PPID</span>

                    <i class="fa-solid fa-chevron-right vm-breadcrumb-separator" aria-hidden="true"></i>

                    <span aria-current="page">
                        Visi dan Misi
                    </span>
                </nav>

                <div class="vm-hero-grid">

                    {{-- Hero copy --}}
                    <div class="vm-hero-copy">

                        <div class="vm-hero-eyebrow">
                            <span class="vm-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-solid fa-compass"></i>
                            </span>

                            <span>
                                Arah Pelayanan Informasi Publik
                            </span>
                        </div>

                        <h1 id="vm-hero-title">
                            Arah yang jelas.
                            <span>Informasi yang lebih dekat.</span>
                        </h1>

                        <p class="vm-hero-description">
                            Visi dan misi PPID DISPUSAKA Provinsi Sulawesi Tengah
                            menjadi arah pelayanan informasi publik yang terbuka,
                            mudah dipahami, dan mudah dijangkau masyarakat.
                        </p>

                        <div class="vm-hero-actions">
                            <a href="#visi-misi" class="vm-primary-button">
                                <span>Lihat Visi & Misi</span>
                                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                            </a>

                            <div class="vm-hero-points" aria-label="Prinsip pelayanan">
                                <span>
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    Transparan
                                </span>

                                <span>
                                    <i class="fa-solid fa-universal-access" aria-hidden="true"></i>
                                    Mudah diakses
                                </span>

                                <span>
                                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                                    Berorientasi publik
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Hero visual --}}
                    <div class="vm-hero-visual" aria-hidden="true">
                        <div class="vm-visual-ring vm-visual-ring-one"></div>
                        <div class="vm-visual-ring vm-visual-ring-two"></div>

                        <div class="vm-visual-card">

                            <div class="vm-visual-card-head">
                                <span class="vm-visual-status">
                                    <span></span>
                                    PPID DISPUSAKA
                                </span>

                                <i class="fa-regular fa-compass"></i>
                            </div>

                            <div class="vm-visual-main">
                                <span class="vm-visual-main-icon">
                                    <i class="fa-solid fa-bullseye"></i>
                                </span>

                                <div>
                                    <small>Fokus layanan</small>

                                    <strong>
                                        Keterbukaan informasi yang jelas
                                        dan dapat dijangkau publik.
                                    </strong>
                                </div>
                            </div>

                            <div class="vm-visual-route">
                                <span class="is-active">
                                    <i class="fa-solid fa-eye"></i>
                                </span>

                                <div></div>

                                <span>
                                    <i class="fa-solid fa-list-check"></i>
                                </span>

                                <div></div>

                                <span>
                                    <i class="fa-solid fa-people-group"></i>
                                </span>
                            </div>

                            <div class="vm-visual-footer">
                                <strong>Visi & Misi</strong>
                                <small>arah layanan informasi publik</small>
                            </div>
                        </div>

                        <div class="vm-floating-card vm-floating-card-one">
                            <i class="fa-solid fa-door-open"></i>

                            <div>
                                <small>Akses informasi</small>
                                <strong>Lebih sederhana</strong>
                            </div>
                        </div>

                        <div class="vm-floating-card vm-floating-card-two">
                            <i class="fa-solid fa-shield-heart"></i>

                            <div>
                                <small>Pelayanan publik</small>
                                <strong>Lebih terbuka</strong>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ======================================================
        CONTENT
        ======================================================= --}}
        <section id="visi-misi" class="vm-content-section" aria-labelledby="vm-content-title">
            <div class="container">

                <div class="vm-section-heading">

                    <div>
                        <span class="vm-section-eyebrow">
                            <i class="fa-solid fa-circle-nodes" aria-hidden="true"></i>
                            Fondasi PPID
                        </span>

                        <h2 id="vm-content-title">
                            Dari arah besar menuju tindakan nyata.
                        </h2>

                        <p>
                            Visi menjelaskan tujuan yang ingin dicapai.
                            Misi menerjemahkannya menjadi arah kerja pelayanan
                            informasi publik.
                        </p>
                    </div>

                    @if ($visimisi?->updated_at)
                        <div class="vm-update-badge">
                            <span class="vm-update-icon" aria-hidden="true">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </span>

                            <div>
                                <small>Terakhir diperbarui</small>
                                <strong>
                                    {{ $visimisi->updated_at->format('d/m/Y') }}
                                </strong>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($visimisi)

                    <div class="vm-main-grid">

                        {{-- Visi --}}
                        <article class="vm-vision-card">

                            <div class="vm-card-decoration" aria-hidden="true"></div>

                            <header class="vm-vision-header">
                                <span class="vm-card-icon" aria-hidden="true">
                                    <i class="fa-solid fa-eye"></i>
                                </span>

                                <div>
                                    <span class="vm-card-label">
                                        Tujuan Utama
                                    </span>

                                    <h3>Visi PPID</h3>
                                </div>
                            </header>

                            <div class="vm-vision-content">
                                <i class="fa-solid fa-quote-left vm-quote-icon" aria-hidden="true"></i>

                                @if ($visi)
                                    <p>
                                        {{ $visi }}
                                    </p>
                                @else
                                    <p class="vm-content-placeholder">
                                        Visi PPID belum tersedia.
                                    </p>
                                @endif
                            </div>
                        </article>

                        {{-- Misi --}}
                        <article class="vm-mission-card">

                            <header class="vm-mission-header">

                                <div class="vm-mission-heading">
                                    <span class="vm-card-icon vm-card-icon-light" aria-hidden="true">
                                        <i class="fa-solid fa-list-check"></i>
                                    </span>

                                    <div>
                                        <span class="vm-card-label">
                                            Langkah Strategis
                                        </span>

                                        <h3>Misi PPID</h3>
                                    </div>
                                </div>

                                @if (count($misiItems) > 0)
                                    <span class="vm-mission-count">
                                        {{ count($misiItems) }}
                                        {{ count($misiItems) === 1 ? 'misi' : 'misi' }}
                                    </span>
                                @endif
                            </header>

                            @if (count($misiItems) > 0)
                                <ol class="vm-mission-list">
                                    @foreach ($misiItems as $item)
                                                    <li>
                                                        <span class="vm-mission-number" aria-hidden="true">
                                                            {{ str_pad(
                                            (string) $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                                        </span>

                                                        <div class="vm-mission-text">
                                                            <span>Misi {{ $loop->iteration }}</span>

                                                            <p>
                                                                {{ $item }}
                                                            </p>
                                                        </div>

                                                        <span class="vm-mission-check" aria-hidden="true">
                                                            <i class="fa-solid fa-check"></i>
                                                        </span>
                                                    </li>
                                    @endforeach
                                </ol>
                            @else
                                <div class="vm-mission-empty">
                                    <span aria-hidden="true">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </span>

                                    <div>
                                        <strong>
                                            Misi belum tersedia
                                        </strong>

                                        <p>
                                            Informasi misi PPID belum
                                            dipublikasikan pada sistem.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </article>

                    </div>

                    {{-- Insight strip --}}
                    <div class="vm-principle-strip">

                        <div class="vm-principle-intro">
                            <span>Makna layanan</span>

                            <strong>
                                Informasi publik dibuat lebih mudah ditemukan,
                                dipahami, dan digunakan.
                            </strong>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-eye"></i>
                            </span>

                            <div>
                                <strong>Terbuka</strong>
                                <small>Informasi lebih mudah dijangkau.</small>
                            </div>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-language"></i>
                            </span>

                            <div>
                                <strong>Jelas</strong>
                                <small>Informasi lebih mudah dipahami.</small>
                            </div>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-user-check"></i>
                            </span>

                            <div>
                                <strong>Responsif</strong>
                                <small>Layanan berorientasi masyarakat.</small>
                            </div>
                        </div>

                    </div>

                @else

                    {{-- Empty state --}}
                    <div class="vm-empty-state">
                        <span class="vm-empty-icon" aria-hidden="true">
                            <i class="fa-regular fa-compass"></i>
                        </span>

                        <div>
                            <span class="vm-empty-label">
                                Informasi belum tersedia
                            </span>

                            <h3>
                                Visi dan Misi PPID sedang dipersiapkan.
                            </h3>

                            <p>
                                Data visi dan misi belum tersedia pada sistem.
                                Informasi akan tampil secara otomatis setelah
                                data dipublikasikan oleh pengelola.
                            </p>
                        </div>
                    </div>

                @endif

            </div>
        </section>

    </div>
@endsection