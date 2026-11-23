@extends('home.layouts.app')

@php
    $namaInstansi = $alamat?->nama
        ?: 'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah';

    $singkatanInstansi = $alamat?->singkatan
        ?: 'DISPUSAKA';
@endphp

@section('title', 'Alamat Instansi - ' . $singkatanInstansi . ' Prov. Sulteng')

@section(
    'meta_description',
    'Alamat, kontak, email, telepon, lokasi, dan media sosial ' . $namaInstansi
)

@push('styles')
    @vite('resources/css/alamat.css')
@endpush

@section('contents')
    <div class="address-page">

        {{-- =========================================================
        HERO
        ========================================================== --}}
        <section class="address-hero" aria-labelledby="address-hero-title">
            <div class="address-hero-pattern" aria-hidden="true"></div>
            <div class="address-hero-orb address-hero-orb-one" aria-hidden="true"></div>
            <div class="address-hero-orb address-hero-orb-two" aria-hidden="true"></div>

            <div class="container">
                {{-- Breadcrumb --}}
                <nav class="address-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>

                    <i class="fa-solid fa-chevron-right address-breadcrumb-separator" aria-hidden="true"></i>

                    <span>PPID</span>

                    <i class="fa-solid fa-chevron-right address-breadcrumb-separator" aria-hidden="true"></i>

                    <span aria-current="page">Alamat Instansi</span>
                </nav>

                <div class="address-hero-grid">
                    {{-- Hero Copy --}}
                    <div class="address-hero-copy">
                        <div class="address-eyebrow">
                            <span class="address-eyebrow-icon" aria-hidden="true">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>

                            <span>Kontak & Lokasi Instansi</span>
                        </div>

                        <h1 id="address-hero-title">
                            Temukan kami.
                            <span>Hubungi kami dengan mudah.</span>
                        </h1>

                        <p class="address-hero-description">
                            Informasi alamat, kontak, lokasi, dan kanal resmi
                            {{ $singkatanInstansi }} tersedia dalam satu halaman
                            agar masyarakat dapat terhubung tanpa langkah yang rumit.
                        </p>

                        <div class="address-hero-actions">
                            <a href="#informasi-alamat" class="address-button address-button-primary">
                                <span>Lihat Informasi Kontak</span>
                                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                            </a>

                            @if ($contactLinks['maps'] ?? null)
                                <a href="{{ $contactLinks['maps'] }}" target="_blank" rel="noopener noreferrer"
                                    class="address-button address-button-secondary"
                                    aria-label="Buka lokasi {{ $singkatanInstansi }} di Google Maps">
                                    <i class="fa-solid fa-diamond-turn-right" aria-hidden="true"></i>
                                    <span>Buka Google Maps</span>
                                </a>
                            @endif
                        </div>

                        <div class="address-hero-meta">
                            @if ($alamat?->email)
                                <span>
                                    <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                    Email tersedia
                                </span>
                            @endif

                            @if ($alamat?->telepon)
                                <span>
                                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                    Kontak telepon
                                </span>
                            @endif

                            @if (($contactLinks['facebook'] ?? null) || ($contactLinks['instagram'] ?? null))
                                <span>
                                    <i class="fa-solid fa-hashtag" aria-hidden="true"></i>
                                    Media sosial resmi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Hero Visual --}}
                    <div class="address-hero-visual" aria-hidden="true">
                        <div class="address-visual-ring address-visual-ring-one"></div>
                        <div class="address-visual-ring address-visual-ring-two"></div>

                        <div class="address-location-visual">
                            <div class="address-location-visual-head">
                                <span>
                                    <span class="address-status-dot"></span>
                                    Lokasi Instansi
                                </span>

                                <i class="fa-solid fa-location-crosshairs"></i>
                            </div>

                            <div class="address-location-pin-wrap">
                                <span class="address-location-radar"></span>

                                <span class="address-location-pin">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                            </div>

                            <div class="address-location-visual-copy">
                                <small>Alamat resmi</small>

                                <strong>
                                    {{ $alamat?->alamat ?: 'Informasi alamat sedang dipersiapkan.' }}
                                </strong>
                            </div>

                            <div class="address-location-visual-footer">
                                <span>
                                    <i class="fa-solid fa-building" aria-hidden="true"></i>
                                    {{ $singkatanInstansi }}
                                </span>

                                @if ($contactLinks['maps'] ?? null)
                                    <span>
                                        <i class="fa-solid fa-route" aria-hidden="true"></i>
                                        Maps tersedia
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="address-floating-card address-floating-card-one">
                            <span class="address-floating-icon">
                                <i class="fa-solid fa-diamond-turn-right"></i>
                            </span>

                            <div>
                                <small>Petunjuk arah</small>
                                <strong>Mudah ditemukan</strong>
                            </div>
                        </div>

                        <div class="address-floating-card address-floating-card-two">
                            <span class="address-floating-icon">
                                <i class="fa-solid fa-headset"></i>
                            </span>

                            <div>
                                <small>Kontak publik</small>
                                <strong>Mudah dihubungi</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
        MAIN INFORMATION
        ========================================================== --}}
        <section id="informasi-alamat" class="address-content-section" aria-labelledby="address-content-title">
            <div class="container">
                <div class="address-section-heading">
                    <div>
                        <span class="address-section-eyebrow">
                            <i class="fa-solid fa-compass" aria-hidden="true"></i>
                            Informasi Instansi
                        </span>

                        <h2 id="address-content-title">
                            Semua yang Anda perlukan untuk terhubung.
                        </h2>

                        <p>
                            Gunakan informasi berikut untuk berkunjung,
                            menghubungi instansi, atau mengakses kanal resmi
                            {{ $singkatanInstansi }}.
                        </p>
                    </div>

                    @if ($alamat?->updated_at)
                        <div class="address-update-badge">
                            <span class="address-update-icon" aria-hidden="true">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </span>

                            <div>
                                <small>Informasi diperbarui</small>
                                <strong>
                                    {{ $alamat->updated_at->format('d/m/Y') }}
                                </strong>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($alamat)
                    <div class="address-main-grid">

                        {{-- Main location card --}}
                        <article class="address-main-card">
                            <div class="address-main-decoration" aria-hidden="true"></div>

                            <header class="address-main-card-header">
                                <span class="address-main-card-icon" aria-hidden="true">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>

                                <div>
                                    <span class="address-card-label">Lokasi Utama</span>
                                    <h3>{{ $namaInstansi }}</h3>
                                </div>
                            </header>

                            <div class="address-main-card-body">
                                @if ($alamat->alamat)
                                    <span class="address-field-label">
                                        Alamat lengkap
                                    </span>

                                    <p class="address-location-text">
                                        {{ $alamat->alamat }}
                                    </p>
                                @else
                                    <p class="address-information-empty">
                                        Informasi alamat belum tersedia.
                                    </p>
                                @endif

                                @if ($contactLinks['maps'] ?? null)
                                    <a href="{{ $contactLinks['maps'] }}" target="_blank" rel="noopener noreferrer"
                                        class="address-direction-button">
                                        <span>
                                            <i class="fa-solid fa-diamond-turn-right" aria-hidden="true"></i>
                                            Petunjuk Arah
                                        </span>

                                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <span class="address-map-unavailable">
                                        <i class="fa-regular fa-map" aria-hidden="true"></i>
                                        Tautan peta belum tersedia
                                    </span>
                                @endif
                            </div>
                        </article>

                        {{-- Contact column --}}
                        <div class="address-contact-column">

                            {{-- Email --}}
                            <article class="address-contact-card">
                                <span class="address-contact-icon">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>

                                <div class="address-contact-content">
                                    <span>Email Resmi</span>

                                    @if ($alamat->email)
                                        <strong>{{ $alamat->email }}</strong>

                                        @if ($contactLinks['email'] ?? null)
                                            <a href="{{ $contactLinks['email'] }}">
                                                Kirim email
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    @else
                                        <strong class="is-muted">
                                            Belum tersedia
                                        </strong>
                                    @endif
                                </div>
                            </article>

                            {{-- Phone --}}
                            <article class="address-contact-card">
                                <span class="address-contact-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </span>

                                <div class="address-contact-content">
                                    <span>Telepon</span>

                                    @if ($alamat->telepon)
                                        <strong>{{ $alamat->telepon }}</strong>

                                        @if ($contactLinks['phone'] ?? null)
                                            <a href="{{ $contactLinks['phone'] }}">
                                                Hubungi sekarang
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    @else
                                        <strong class="is-muted">
                                            Belum tersedia
                                        </strong>
                                    @endif
                                </div>
                            </article>

                            {{-- Agency identity --}}
                            <article class="address-contact-card address-identity-card">
                                <span class="address-contact-icon">
                                    <i class="fa-solid fa-building-columns"></i>
                                </span>

                                <div class="address-contact-content">
                                    <span>Instansi</span>

                                    <strong>
                                        {{ $alamat->singkatan ?: $alamat->nama }}
                                    </strong>

                                    @if ($alamat->singkatan && $alamat->nama)
                                        <p>{{ $alamat->nama }}</p>
                                    @endif
                                </div>
                            </article>
                        </div>
                    </div>

                    {{-- =====================================================
                    SOCIAL AND QUICK ACCESS
                    ====================================================== --}}
                    <div class="address-connect-strip">
                        {{-- <div class="address-connect-intro">
                            <span>Terhubung dengan kami</span>

                            <strong>
                                Pilih kanal yang paling sesuai dengan kebutuhan Anda.
                            </strong>
                        </div> --}}

                        @if ($contactLinks['maps'] ?? null)
                            <a href="{{ $contactLinks['maps'] }}" target="_blank" rel="noopener noreferrer"
                                class="address-connect-item">
                                <span class="address-connect-icon">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </span>

                                <div>
                                    <strong>Google Maps</strong>
                                    <small>Lihat lokasi dan petunjuk arah</small>
                                </div>

                                <i class="fa-solid fa-arrow-up-right-from-square address-connect-arrow" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if ($contactLinks['facebook'] ?? null)
                            <a href="{{ $contactLinks['facebook'] }}" target="_blank" rel="noopener noreferrer"
                                class="address-connect-item">
                                <span class="address-connect-icon">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </span>

                                <div>
                                    <strong>Facebook</strong>
                                    <small>Ikuti informasi dan kegiatan</small>
                                </div>

                                <i class="fa-solid fa-arrow-up-right-from-square address-connect-arrow" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if ($contactLinks['instagram'] ?? null)
                            <a href="{{ $contactLinks['instagram'] }}" target="_blank" rel="noopener noreferrer"
                                class="address-connect-item">
                                <span class="address-connect-icon">
                                    <i class="fa-brands fa-instagram"></i>
                                </span>

                                <div>
                                    <strong>Instagram</strong>
                                    <small>Lihat publikasi terbaru</small>
                                </div>

                                <i class="fa-solid fa-arrow-up-right-from-square address-connect-arrow" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if (
                                !($contactLinks['maps'] ?? null) &&
                                !($contactLinks['facebook'] ?? null) &&
                                !($contactLinks['instagram'] ?? null)
                            )
                            <div class="address-connect-placeholder">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>
                                    Kanal eksternal belum tersedia.
                                </span>
                            </div>
                        @endif
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="address-empty-state">
                        <span class="address-empty-icon" aria-hidden="true">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>

                        <div>
                            <span class="address-empty-label">
                                Informasi belum tersedia
                            </span>

                            <h3>
                                Data alamat instansi sedang dipersiapkan.
                            </h3>

                            <p>
                                Informasi lokasi dan kontak akan ditampilkan
                                otomatis setelah data tersedia pada sistem.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        {{-- =========================================================
        CLOSING CTA
        ========================================================== --}}
        @if ($alamat)
            <section class="address-closing-section">
                <div class="container">
                    <div class="address-closing-card">
                        <div class="address-closing-copy">
                            <span>Perlu datang langsung?</span>

                            <h2>
                                Temukan {{ $singkatanInstansi }} dengan lebih mudah.
                            </h2>

                            <p>
                                Gunakan informasi lokasi resmi di atas sebelum
                                melakukan kunjungan ke kantor.
                            </p>
                        </div>

                        <div class="address-closing-actions">
                            @if ($contactLinks['maps'] ?? null)
                                <a href="{{ $contactLinks['maps'] }}" target="_blank" rel="noopener noreferrer"
                                    class="address-button address-button-primary">
                                    <i class="fa-solid fa-diamond-turn-right" aria-hidden="true"></i>

                                    <span>Buka Petunjuk Arah</span>
                                </a>
                            @endif

                            @if ($contactLinks['phone'] ?? null)
                                <a href="{{ $contactLinks['phone'] }}" class="address-button address-button-on-dark">
                                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                    <span>Hubungi Instansi</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection