<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="#071A33" name="theme-color" />
    <meta content="Portal layanan Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah." name="description" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-Sulteng.png') }}">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    {!! SEO::generate() !!}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('dispusaka/styles.css') }}" rel="stylesheet">
    </link>
    <style>
        /* Ukuran khusus kartu Portal Resmi pada halaman sambutan */
        .hero-welcome .welcome-signature {
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 22px auto 0;
        }

        .hero-welcome .welcome-signature>.service-card.featured {
            width: min(100%, 360px);
            max-width: 360px;
            min-height: 0;
            height: auto;
            padding: 16px 18px;
            box-sizing: border-box;
        }

        .hero-welcome .welcome-signature>.service-card.featured .card-icon {
            width: 46px;
            height: 46px;
        }

        .hero-welcome .welcome-signature>.service-card.featured .card-icon i {
            font-size: 1.25rem;
        }

        .hero-welcome .welcome-signature>.service-card.featured .card-copy h3 {
            font-size: 1rem;
            line-height: 1.35;
            margin-bottom: 6px;
        }

        .hero-welcome .welcome-signature>.service-card.featured .card-copy p {
            font-size: 0.78rem;
            line-height: 1.45;
        }

        .hero-welcome .welcome-signature>.service-card.featured .badge {
            font-size: 0.65rem;
            padding: 5px 9px;
        }

        @media (max-width: 480px) {
            .hero-welcome .welcome-signature>.service-card.featured {
                width: min(100%, 320px);
                padding: 14px 16px;
            }
        }

        .brand-mark-image {
            width: 54px;
            height: 54px;
            min-width: 54px;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            overflow: hidden;
        }

        .brand-mark-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
    </style>
</head>

<body data-page="index.html">
    <div class="page-shell">
        <video class="background-video" autoplay muted loop playsinline preload="metadata"
            aria-hidden="true" tabindex="-1">
            <source src="{{ asset('assets/images/pusarda.mp4') }}" type="video/mp4">
        </video>
        <div class="ambient ambient-a"></div>
        <div class="ambient ambient-b"></div>
        <header class="topbar">
            <a aria-label="Beranda Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah" class="brand"
                href="index.html">
                <div class="brand-mark brand-mark-image">
                    <img src="{{ asset('assets/images/Logo-Sulteng.png') }}" alt="Logo DISPUSAKA Sulawesi Tengah">
                </div>
                <div class="brand-copy">
                    <strong><span>dispusaka</span>sulteng</strong>
                    <small>Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah</small>
                </div>
            </a>
            <div class="top-actions top-branding" aria-label="Identitas ASN">
                <div class="asn-logo-placeholder asn-berakhlak-placeholder"
                    style="background-color:#ffffff; padding:6px 10px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <img src="{{ asset('assets/images/Logo_BerAKHLAK.png') }}" alt="Logo ASN BerAKHLAK"
                        style="display:block; max-width:100%; max-height:42px; width:auto; height:auto; object-fit:contain;">
                </div>

                <div class="asn-logo-placeholder bangga-asn-placeholder"
                    style="background-color:#ffffff; padding:6px 10px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <img src="{{ asset('assets/images/Logo_EVP.png') }}" alt="Logo Bangga Jadi ASN"
                        style="display:block; max-width:100%; max-height:42px; width:auto; height:auto; object-fit:contain;">
                </div>
            </div>
        </header>
        <main class="content">
            <section aria-labelledby="heroTitle" class="hero hero-welcome" id="beranda">
                <div class="hero-message">
                    <p class="eyebrow">Selamat datang</p>
                    <h1 id="heroTitle">Portal Resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah</h1>
                    <p class="hero-subtitle">Melalui portal ini, kami berkomitmen menghadirkan layanan perpustakaan dan
                        kearsipan yang mudah diakses, informatif, inklusif, serta mendukung peningkatan budaya literasi
                        dan tertib arsip. Mari bersama membangun masyarakat Sulawesi Tengah yang gemar membaca, cerdas,
                        dan sadar arsip.</p>
                    <div class="welcome-signature">
                        <a class="service-card featured"
                            data-title="website dispusaka prov sulteng portal resmi dinas perpustakaan dan kearsipan sulawesi tengah"
                            href="{{ route('beranda') }}" rel="noopener">
                            <span class="badge">Portal Resmi</span>
                            <div class="card-icon">
                                <i aria-hidden="true" class="fa-solid fa-globe"></i>
                            </div>
                            <div class="card-copy">
                                <h3>Website Dispusaka Prov Sulteng</h3>
                                <p>Akses portal resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah.</p>
                            </div>
                            <span class="arrow"><i aria-hidden="true"
                                    class="fa-solid fa-arrow-up-right-from-square"></i></span>
                        </a>
                    </div>
                    <div class="service-hours-card" aria-label="Jam layanan perpustakaan">
                        <div class="service-hours-head">
                            <span class="service-hours-icon" aria-hidden="true"><i
                                    class="fa-regular fa-clock"></i></span>
                            <div class="service-hours-title">
                                <span>Jam Layanan Perpustakaan</span>
                                <strong>Informasi Operasional</strong>
                            </div>
                        </div>
                        <div class="service-hours-grid">
                            <div class="hours-row">
                                <span class="hours-day">Senin – Kamis</span>
                                <strong>08.00 – 16.00 WITA</strong>
                            </div>
                            <div class="hours-row hours-row-friday">
                                <span class="hours-day">Jumat</span>
                                <strong>08.00 – 16.30 WITA</strong>
                                <small><i class="fa-solid fa-mug-hot" aria-hidden="true"></i> Istirahat 11.00 – 13.00
                                    WITA</small>
                            </div>
                            <div class="hours-row">
                                <span class="hours-day">Sabtu</span>
                                <strong>08.00 – 14.00 WITA</strong>
                            </div>
                        </div>
                        <div class="service-hours-closed">
                            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                            <span><strong>Layanan Perpustakaan Ditutup</strong><small>Minggu, Libur Nasional, dan Cuti
                                    Bersama</small></span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="footer" id="kontak">
            <div>
                <p>© 2026 Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah</p>
                <p class="footer-address">Jl. Banteng No. 6, Kota Palu</p>
            </div>
            <div class="footer-links">
                <a href="https://dispusarda.sultengprov.go.id/profil_dinas" rel="noopener" target="_blank">Profil</a>
                <a href="https://dispusarda.sultengprov.go.id/publik" rel="noopener" target="_blank">Berita</a>
                <a href="mailto:sultengperpus@gmail.com">Kontak</a>
            </div>
        </footer>
        <button id="accessibilityToggle" class="accessibility-icon" type="button"
            aria-label="Buka aksesibilitas suara" aria-expanded="false">
            <i class="fa-solid fa-wheelchair" aria-hidden="true"></i>
        </button>
        <div id="voicePanel" class="voice-panel" hidden>
            <button id="voiceToggle" class="voice-toggle" type="button" aria-pressed="false"
                aria-label="Aktifkan Text to Speech">
                <i class="fa-solid fa-volume-high" aria-hidden="true"></i>
                <span>Aktifkan Text to Speech</span>
            </button>
        </div>
        <a aria-label="Hubungi DISPUSAKA Sulteng" class="floating-help" href="mailto:sultengperpus@gmail.com"
            title="Hubungi DISPUSAKA Sulteng">
            <i aria-hidden="true" class="fa-solid fa-envelope"></i>
        </a>
        <aside aria-hidden="true" aria-label="Identitas ASN" class="mobile-panel" id="mobilePanel">
            <div class="mobile-panel-head asn-panel-head">
                <button aria-label="Tutup panel" id="closeMenu" type="button"><i aria-hidden="true"
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="asn-placeholder-wrap" aria-label="Placeholder logo ASN">
                <div class="asn-brand-placeholder asn-berakhlak-placeholder" role="img"
                    aria-label="Placeholder logo ASN BerAKHLAK">
                    <span class="asn-brand-small">ASN</span>
                    <strong>BERAKHLAK</strong>
                </div>
                <div class="asn-brand-placeholder bangga-asn-placeholder" role="img"
                    aria-label="Placeholder logo Bangga Jadi ASN">
                    <strong>BANGGA JADI ASN</strong>
                </div>
            </div>
        </aside>
        <div class="scrim" id="scrim"></div>
    </div>
    <script src="{{ asset('dispusaka/script.js') }}"></script>
</body>

</html>
