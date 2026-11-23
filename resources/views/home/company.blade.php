@extends('home.layouts.app')
@section('title', 'Visi dan Misi - Dispusaka Prov. Sulteng')

@section('contents')

    @php
        $visi = trim((string) ($data->visi ?? ''));
        $misi = trim((string) ($data->misi ?? ''));
    @endphp

    <section class="vision-page" aria-labelledby="vision-page-title">

        {{-- HERO --}}
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
                    <span aria-current="page">Visi dan Misi</span>
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
                            Visi dan <span>Misi</span>Sulawesi Tengah
                        </h1>

                        <p class="history-hero-description">
                            Landasan strategis yang menjadi arah organisasi dalam menetapkan tujuan, menjalankan pelayanan,
                            serta membangun komitmen yang berkelanjutan.
                        </p>

                        <div class="history-hero-actions">
                            <a href="#visi-dan-misi" class="history-primary-button">
                                <span>Baca Visi dan Misi</span>
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

        {{-- CONTENT INTRODUCTION --}}
        <div class="vision-content-section" id="visi-dan-misi">
            <div class="container">
                <header class="vision-section-heading">
                    <div>
                        <span class="vision-eyebrow">
                            <i class="fa-solid fa-circle" aria-hidden="true"></i>
                            Landasan Strategis
                        </span>
                        <h2>Arah dan Komitmen Organisasi</h2>
                        <p>
                            Visi menetapkan gambaran tujuan yang ingin dicapai, sedangkan misi menerjemahkan tujuan tersebut
                            ke dalam langkah dan komitmen organisasi.
                        </p>
                    </div>

                    <div class="vision-heading-mark" aria-hidden="true">
                        <span><i class="fa-solid fa-compass"></i></span>
                        <div>
                            <small>Fokus Utama</small>
                            <strong>Tujuan &amp; Strategi</strong>
                        </div>
                    </div>
                </header>

                {{-- VISI & MISI GRID --}}
                <div class="vision-content-grid">

                    {{-- VISI --}}
                    <article class="vision-content-card vision-content-card--vision" aria-labelledby="vision-title">
                        <div class="vision-card-decoration" aria-hidden="true"></div>
                        <div class="vision-card-top">
                            <div class="vision-card-icon">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                            </div>
                            <span class="vision-card-number" aria-hidden="true">01</span>
                        </div>
                        <div class="vision-card-label">Visi</div>
                        <h2 id="vision-title">Visi Gubernur dan Wakil Gubernur Sulawesi Tengah</h2>
                        <div class="vision-card-divider" aria-hidden="true"><span></span></div>
                        <div class="vision-richtext vision-richtext--dark">
                            @if ($visi !== '')
                                <h3 id="vision-title">"{!! $visi !!}"</h3>
                            @else
                                <div class="vision-empty-state">
                                    <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                                    <div>
                                        <strong>Visi belum tersedia</strong>
                                        <span>
                                            Informasi visi organisasi akan ditampilkan pada bagian ini.
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>


                    {{-- MISI --}}
                    <article class="vision-content-card vision-content-card--mission" aria-labelledby="mission-title">
                        <div class="vision-card-top">
                            <div class="vision-card-icon vision-card-icon--gold">
                                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            </div>
                            <span class="vision-card-number" aria-hidden="true">02</span>
                        </div>
                        <div class="vision-card-label vision-card-label--blue">Misi</div>
                        <h2 id="mission-title">Langkah Strategis Organisasi</h2>
                        <div class="vision-card-divider vision-card-divider--light" aria-hidden="true">
                            <span></span>
                        </div>
                        <div class="vision-richtext">
                            @if ($misi !== '')
                                {!! $misi !!}
                            @else
                                <div class="vision-empty-state">
                                    <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                                    <div>
                                        <strong>Misi belum tersedia</strong>
                                        <span>
                                            Informasi misi organisasi akan ditampilkan pada bagian ini.
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                {{-- CLOSING STATEMENT --}}
                <aside class="vision-statement" aria-label="Komitmen organisasi">
                    <div class="vision-statement-icon" aria-hidden="true">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <div class="vision-statement-content">
                        <span>Komitmen Organisasi</span>
                        <blockquote>
                            Setiap langkah organisasi dibangun berdasarkan visi yang jelas dan misi yang terarah untuk
                            menciptakan nilai dan dampak positif secara berkelanjutan.
                        </blockquote>
                    </div>
                    <div class="vision-statement-symbol" aria-hidden="true">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
