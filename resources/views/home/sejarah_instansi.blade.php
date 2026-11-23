@extends('home.layouts.app')
@section('title', 'Sejarah Instansi - DISPUSAKA Provinsi Sulawesi Tengah')

@section('contents')
    <div class="history-page">
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
                    <span aria-current="page">Sejarah Instansi</span>
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
                            Jejak Perjalanan<span>DISPUSAKA</span>Sulawesi Tengah
                        </h1>

                        <p class="history-hero-description">
                            Mengenal perjalanan Dinas Perpustakaan dan Kearsipan
                            Provinsi Sulawesi Tengah sebagai bagian dari pelayanan
                            publik di bidang perpustakaan dan kearsipan.
                        </p>

                        <div class="history-hero-actions">
                            <a href="#sejarah-instansi" class="history-primary-button">
                                <span>Baca Sejarah Instansi</span>
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

        <section class="history-content-section" id="sejarah-instansi" aria-labelledby="historyContentTitle">

            <div class="container">

                <div class="history-section-heading">
                    <div>
                        <span class="eyebrow">Mengenal DISPUSAKA</span>
                        <h2 id="historyContentTitle">Sejarah Instansi</h2>

                        <p>
                            Perjalanan kelembagaan Dinas Perpustakaan dan Kearsipan
                            Provinsi Sulawesi Tengah.
                        </p>
                    </div>

                    <div class="history-section-status">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>
                            <small>Sumber Konten</small>Profil Resmi Instansi
                        </span>
                    </div>
                </div>

                <div class="history-reading-layout">
                    <article class="history-article">
                        <header class="history-article-header">
                            <div class="history-article-icon">
                                <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                            </div>

                            <div>
                                <span>Dokumentasi Kelembagaan</span>
                                <h3>Perjalanan Dinas Perpustakaan dan Kearsipan</h3>
                            </div>
                        </header>

                        @if (count($historyParagraphs))
                            <div class="history-prose">
                                @foreach ($historyParagraphs as $paragraph)
                                    @php
                                        $paragraph = trim($paragraph);
                                    @endphp
                                    @if ($paragraph !== '')
                                        <p style="text-align: justify;">
                                            {!! nl2br(trim(html_entity_decode(strip_tags($paragraph)))) !!}
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            {{-- Empty State --}}
                            <div class="history-empty-state">
                                <div class="history-empty-icon">
                                    <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                                </div>

                                <div>
                                    <h3>Konten sejarah belum tersedia</h3>
                                    <p>
                                        Informasi sejarah instansi sedang dipersiapkan
                                        dan akan ditampilkan pada halaman ini setelah
                                        tersedia.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <footer class="history-article-footer">
                            <div class="history-article-footer-icon">
                                <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                            </div>
                            <p>
                                Halaman ini merupakan bagian dari profil kelembagaan
                                Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi
                                Tengah.
                            </p>
                        </footer>
                    </article>

                    <aside class="history-sidebar" aria-label="Informasi profil terkait">
                        {{-- Agency Card --}}
                        <div class="history-side-card history-agency-card">
                            <div class="history-side-card-label">
                                <i class="fa-solid fa-landmark" aria-hidden="true"></i>
                                <span>Tentang Instansi</span>
                            </div>

                            <div class="history-side-logo">
                                <img src="{{ asset('assets/images/Logo-Sulteng.png') }}"
                                    alt="Logo Provinsi Sulawesi Tengah">
                            </div>

                            <h3>DISPUSAKA Sulawesi Tengah</h3>
                            <p>
                                Dinas Perpustakaan dan Kearsipan
                                Provinsi Sulawesi Tengah.
                            </p>

                            <div class="history-agency-tags">
                                <span>
                                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>Perpustakaan
                                </span>
                                <span>
                                    <i class="fa-solid fa-box-archive" aria-hidden="true"></i>Kearsipan
                                </span>
                            </div>
                        </div>

                        {{-- Related Profile --}}
                        <div class="history-side-card">
                            <div class="history-side-heading">
                                <span>Jelajahi Profil</span>
                                <p>Kenali organisasi DISPUSAKA lebih lengkap.</p>
                            </div>

                            <div class="history-profile-links">
                                <a href="https://dispusarda.sultengprov.go.id/profil_dinas/eb992c7a-929d-4921-8c49-a648318292ae"
                                    target="_blank" rel="noopener">
                                    <span class="history-profile-link-icon">
                                        <i class="fa-solid fa-bullseye" aria-hidden="true"></i>
                                    </span>

                                    <span class="history-profile-link-content">
                                        <strong>Visi dan Misi</strong>
                                        <small>Arah dan tujuan organisasi</small>
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                </a>

                                <a href="https://dispusarda.sultengprov.go.id/profil_dinas/f671ba3d-4bc6-4a9b-a412-fe5dfd524164"
                                    target="_blank" rel="noopener">
                                    <span class="history-profile-link-icon">
                                        <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    </span>
                                    <span class="history-profile-link-content">
                                        <strong>Tugas dan Fungsi</strong>
                                        <small>Mandat dan fungsi dinas</small>
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                </a>

                                <a href="https://dispusarda.sultengprov.go.id/profil_dinas/19d46ac3-1f02-4c7b-84a8-5ec7f97baf53"
                                    target="_blank" rel="noopener">
                                    <span class="history-profile-link-icon">
                                        <i class="fa-solid fa-sitemap" aria-hidden="true"></i>
                                    </span>
                                    <span class="history-profile-link-content">
                                        <strong>Struktur Organisasi</strong>
                                        <small>Susunan organisasi DISPUSAKA</small>
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="history-value-section">
            <div class="container">
                <div class="history-value-heading">
                    <span class="eyebrow">Jejak Kelembagaan</span>
                    <h2>Menjaga memori, melayani informasi</h2>
                    <p>
                        Dokumentasi sejarah membantu masyarakat memahami identitas,
                        perjalanan, dan perkembangan sebuah instansi pemerintah.
                    </p>
                </div>

                <div class="history-value-grid">
                    <div class="history-value-card">
                        <span class="history-value-number">01</span>
                        <div class="history-value-icon">
                            <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                        </div>
                        <h3>Memori Organisasi</h3>
                        <p>
                            Menyajikan perjalanan kelembagaan dalam satu informasi
                            yang mudah dibaca.
                        </p>
                    </div>

                    <div class="history-value-card">
                        <span class="history-value-number">02</span>
                        <div class="history-value-icon">
                            <i class="fa-solid fa-file-shield" aria-hidden="true"></i>
                        </div>
                        <h3>Dokumentasi Publik</h3>
                        <p>
                            Membantu masyarakat mengenali latar belakang dan
                            identitas organisasi.
                        </p>
                    </div>

                    <div class="history-value-card">
                        <span class="history-value-number">03</span>
                        <div class="history-value-icon">
                            <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                        </div>
                        <h3>Akses Informasi</h3>
                        <p>
                            Menempatkan informasi kelembagaan dalam tampilan yang
                            jelas, nyaman, dan responsif.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
