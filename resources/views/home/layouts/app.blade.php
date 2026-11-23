<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-Sulteng.png') }}">
    {!! SEO::generate() !!}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/dispusaka.css', 'resources/css/profile.css', 'resources/css/accessibility.css', 'resources/css/struktur.css'])
    @stack('styles')
</head>

<body>
    <div class="topbar">
        <div class="container topbar-inner">
            <div class="topbar-left">
                <span><i class="fa-solid fa-location-dot"></i>Jl. Banteng No. 6, Kota Palu, Sulawesi Tengah</span>
                <span><i class="fa-regular fa-clock"></i>Senin–Jumat, 08.00–16.00 WITA</span>
            </div>
            <div class="topbar-right">
                <span><i class="fa-solid fa-headset"></i>Layanan Informasi Publik</span>
                <div class="topbar-social">
                    <a aria-label="Facebook" href="http://facebook.com/dispusakasulteng">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a aria-label="Instagram" href="https://www.instagram.com/dispusakasulteng_official/">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a aria-label="YouTube" href="https://www.youtube.com/@dispusakaprovsulteng5686">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header class="nav-wrap">
        <div class="container navbar">
            <a class="brand" href="{{ route('beranda') }}">
                <div class="brand-mark">
                    <img src="{{ asset('assets/images/Logo-Sulteng.png') }}" alt="Logo Sulawesi Tengah">
                </div>
                <div class="brand-text">
                    <small>Pemerintah Provinsi Sulawesi Tengah</small>
                    <strong>DISPUSAKA</strong>
                    <span>Dinas Perpustakaan dan Kearsipan</span>
                </div>
            </a>
            <nav aria-label="Navigasi utama" class="nav-menu" id="navMenu">
                <div class="nav-item">
                    <a class="active" href="{{ route('beranda') }}">
                        <i aria-hidden="true" class="fa-solid fa-house nav-main-icon"></i> Beranda
                    </a>
                </div>
                <div class="nav-item has-dropdown">
                    <button aria-expanded="false" class="nav-link dropdown-toggle" type="button">
                        <span>
                            <i aria-hidden="true" class="fa-solid fa-building-columns nav-main-icon"></i>
                            Profil
                        </span>
                        <i aria-hidden="true" class="fa-solid fa-chevron-down nav-chevron"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('sejarah-instansi') }}">
                            <span class="drop-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                            <span><strong>Sejarah Dinas</strong><small>Riwayat DISPUSAKA Sulteng</small></span>
                        </a>
                        <a href="{{ route('visi-misi') }}">
                            <span class="drop-icon"><i class="fa-solid fa-bullseye"></i></span>
                            <span><strong>Visi dan Misi</strong><small>Arah dan tujuan organisasi</small></span>
                        </a>
                        <a href="{{ route('tugas-dan-fungsi') }}">
                            <span class="drop-icon"><i class="fa-solid fa-list-check"></i></span>
                            <span><strong>Tugas dan Fungsi</strong><small>Mandat dan fungsi dinas</small></span>
                        </a>
                        <a href="{{ route('struktur-organisasi') }}">
                            <span class="drop-icon"><i class="fa-solid fa-sitemap"></i></span>
                            <span><strong>Struktur Organisasi</strong><small>Susunan organisasi DISPUSAKA</small></span>
                        </a>
                    </div>
                </div>
                <div class="nav-item has-dropdown">
                    <button aria-expanded="false" class="nav-link dropdown-toggle" type="button">
                        <span>
                            <i aria-hidden="true" class="fa-solid fa-circle-info nav-main-icon"></i> Informasi
                        </span>
                        <i aria-hidden="true" class="fa-solid fa-chevron-down nav-chevron"></i>
                    </button>
                    <div class="dropdown-menu compact-dropdown">
                        <a href="{{ route('berita-dispusaka') }}">
                            <span class="drop-icon"><i class="fa-regular fa-newspaper"></i></span>
                            <span><strong>Berita</strong><small>Kegiatan terbaru dinas</small></span>
                        </a>
                        <a href="{{ route('koleksi-video') }}">
                            <span class="drop-icon"><i class="fa-solid fa-circle-play"></i></span>
                            <span><strong>Video</strong><small>Dokumentasi audiovisual</small></span>
                        </a>
                        <a href="{{ route('pamflet-dispusaka') }}">
                            <span class="drop-icon"><i class="fa-regular fa-image"></i></span>
                            <span><strong>Pamflet</strong><small>Informasi visual publik</small></span>
                        </a>
                        <a href="{{ route('ipussulteng') }}">
                            <span class="drop-icon"><i class="fa-solid fa-book-open-reader"></i></span>
                            <span><strong>iPusSulteng</strong><small>Perpustakaan digital</small></span>
                        </a>
                        {{-- <a href="{{ route('koleksi-buku') }}">
                            <span class="drop-icon"><i class="fa-solid fa-database"></i></span>
                            <span><strong>OPAC</strong><small>Online Public Access Catalog</small></span>
                        </a> --}}
                    </div>
                </div>
                <div class="nav-item">
                    <a href="{{ route('faq-dispusaka') }}">
                        <i aria-hidden="true" class="fa-solid fa-question-circle nav-main-icon"></i> FAQ
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('informasi-publik') }}">
                        <i aria-hidden="true" class="fa-solid fa-solid fa-bullhorn nav-main-icon"></i> Informasi Publik
                    </a>
                </div>
                <div class="nav-item has-dropdown">
                    <button aria-expanded="false" class="nav-link dropdown-toggle" type="button">
                        <span><i aria-hidden="true" class="fa-solid fa-shield-halved nav-main-icon"></i> PPID</span>
                        <i aria-hidden="true" class="fa-solid fa-chevron-down nav-chevron"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right compact-dropdown">
                        <a href="" rel="noopener">
                            <span class="drop-icon"><i class="fa-solid fa-building-user"></i></span>
                            <span><strong>Profil PPID</strong><small>Profil PPID Pelaksana Dispusaka</small>
                            </span>
                        </a>
                        <a href="{{ route('ppid.visi-misi') }}" rel="noopener">
                            <span class="drop-icon"><i class="fa-solid fa-bullseye"></i></span>
                            <span><strong>Visi dan Misi</strong><small>Arah dan tujuan PPID</small>
                            </span>
                        </a>
                        <a href="{{ route('ppid.tugas') }}" rel="noopener">
                            <span class="drop-icon"><i class="fa-solid fa-list-check"></i></span>
                            <span><strong>Tugas dan Tanggung Jawab</strong>
                                <small>Mandat dan fungsi PPID</small>
                            </span>
                        </a>
                        <a href="{{ route('ppid.alamat') }}" rel="noopener">
                            <span class="drop-icon"><i class="fa-solid fa-box-archive"></i></span>
                            <span><strong>Alamat Instansi</strong>
                                <small>Alamat Instansi Dispusaka Prov. Sulteng</small>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="nav-item has-dropdown">
                    <button aria-expanded="false" class="nav-link dropdown-toggle" type="button">
                        <span><i aria-hidden="true" class="fa-solid fa-scale-balanced nav-main-icon"></i> JDIH</span>
                        <i aria-hidden="true" class="fa-solid fa-chevron-down nav-chevron"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right compact-dropdown">
                        <a href="https://www.jdih.sultengprov.go.id" rel="noopener" target="_blank">
                            <span class="drop-icon"><i class="fa-solid fa-scale-balanced"></i></span>
                            <span><strong>Pemprov Sulteng</strong><small>JDIH Pemerintah Provinsi</small>
                            </span>
                        </a>
                        <a href="https://jdih.perpusnas.go.id" rel="noopener" target="_blank">
                            <span class="drop-icon"><i class="fa-solid fa-book"></i></span>
                            <span><strong>Perpusnas RI</strong><small>JDIH Perpustakaan Nasional</small></span>
                        </a>
                        <a href="https://jdih.anri.go.id" rel="noopener" target="_blank">
                            <span class="drop-icon"><i class="fa-solid fa-box-archive"></i></span>
                            <span><strong>ANRI RI</strong><small>JDIH Arsip Nasional</small></span>
                        </a>
                    </div>
                </div>
                <div class="nav-item">
                    <a class="nav-cta" href="https://laportuaka.lapor.go.id" rel="noopener" target="_blank">
                        <i aria-hidden="true" class="fa-solid fa-paper-plane"></i> Span Lapor!
                    </a>
                </div>
            </nav>
            <button aria-label="Buka menu" class="menu-toggle" id="menuToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>
    <main>
        @yield('contents')
    </main>
    <x-accessibility-menu />

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">
                        <div class="brand-mark">
                            <img src="{{ asset('assets/images/Logo-Sulteng.png') }}" alt="Logo Sulawesi Tengah">
                        </div>
                        <div><strong>DISPUSAKA Sulteng</strong><span>Dinas Perpustakaan dan Kearsipan</span></div>
                    </div>
                    <p>Portal informasi resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah untuk
                        mendukung
                        budaya literasi, tata kelola arsip, dan pelayanan publik berbasis digital.</p>
                </div>
                <div>
                    <h4>Tautan Cepat</h4>
                    <div class="footer-links">
                        <a href="{{ route('beranda') }}">Beranda</a>
                        <a href="#layanan">Layanan</a>
                        <a href=" #berita">Berita Kegiatan</a>
                        <a href="#video">Video Kegiatan</a>
                        <a href="#informasi">Pamflet Informasi</a>
                    </div>
                </div>
                <div>
                    <h4>Layanan</h4>
                    <div class="footer-links">
                        <a href="https://inlislite.sultengprov.go.id" target="_blank">OPAC</a>
                        <a href="#">Anggota Perpustakaan</a>
                        <a href="#">Bebas Pustaka</a>
                        <a href="{{ route('ipussulteng') }}">iPusSulteng</a>
                        <a href="https://akreditasi.perpusnas.go.id" target="_blank">Akreditasi</a>
                    </div>
                </div>
                <div>
                    <h4>Kontak</h4>
                    <div class="contact-line"><i class="fa-solid fa-location-dot"></i><span>Jl. Banteng No. 6,
                            Kota
                            Palu, Sulawesi Tengah</span></div>
                    <div class="contact-line"><i
                            class="fa-solid fa-globe"></i><span>dispusarda.sultengprov.go.id</span>
                    </div>
                    <div class="contact-line"><i
                            class="fa-brands fa-instagram"></i><span>@dispusakasulteng_official</span></div>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© <span id="year"></span> Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi
                    Tengah.</span>
                <span>Version 2.0 — Dikembangkan oleh IT Dinas Perpustakaan dan Kearsipan.</span>
            </div>
        </div>
    </footer>

    <button aria-label="Kembali ke atas" class="back-top" id="backTop"><i
            class="fa-solid fa-arrow-up"></i></button>
    @vite(['resources/js/dispusaka.js', 'resources/js/accessibility.js'])
    @stack('scripts')
</body>

</html>
