@extends('home.layouts.app')

@section('title', 'iPusSulteng - Perpustakaan Digital DISPUSAKA Sulawesi Tengah')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/ipussulteng.css') }}">
    {{-- BreadcrumbList dan MobileApplication: data dari IpussultengController. --}}
    <script type="application/ld+json">{!! json_encode(
        $ipusStructuredData,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    ) !!}</script>
@endpush

@section('contents')
    <div class="ipus-page">
        {{-- HERO: menggunakan identitas warna, container dan font dari layout DISPUSAKA. --}}
        <section class="ipus-hero" aria-labelledby="ipus-page-title">
            <div class="ipus-hero-noise" aria-hidden="true"></div>
            <div class="container ipus-hero-container">
                <nav class="ipus-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i> Beranda
                    </a>
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    <span>Layanan Digital</span>
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    <span aria-current="page">iPusSulteng</span>
                </nav>

                <div class="ipus-hero-grid">
                    <div class="ipus-hero-copy">
                        <span class="ipus-eyebrow ipus-eyebrow--light">
                            <span class="ipus-pulse" aria-hidden="true"></span>
                            Inovasi Layanan Perpustakaan Digital
                        </span>
                        <h1 id="ipus-page-title">Jelajahi dunia lewat <span>satu genggaman.</span></h1>
                        <p class="ipus-hero-description">
                            Kenali <strong>iPusSulteng</strong>, inovasi perpustakaan digital Dinas Perpustakaan dan
                            Kearsipan Provinsi Sulawesi Tengah yang menghadirkan akses bahan bacaan lebih dekat,
                            praktis, dan fleksibel melalui perangkat seluler.
                        </p>

                        <div class="ipus-hero-actions">
                            <a class="ipus-btn ipus-btn--yellow" href="#unduh-aplikasi">
                                <i class="fa-solid fa-download" aria-hidden="true"></i>
                                Unduh Aplikasi
                                <i class="fa-solid fa-arrow-right ipus-btn-arrow" aria-hidden="true"></i>
                            </a>
                            <a class="ipus-btn ipus-btn--outline" href="#pendaftaran-akun">
                                Cara Mendapatkan Akun
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        </div>

                        <div class="ipus-hero-meta" aria-label="Informasi layanan">
                            <span><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Layanan DISPUSAKA</span>
                            <span><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> Android &amp; iOS</span>
                            <span><i class="fa-solid fa-book-open-reader" aria-hidden="true"></i> Bacaan digital</span>
                        </div>
                    </div>

                    {{-- Ilustrasi konseptual (bukan tangkapan layar aktual aplikasi). --}}
                    <div class="ipus-hero-art" aria-hidden="true">
                        <div class="ipus-art-glow"></div>
                        <div class="ipus-art-orbit ipus-art-orbit--outer"></div>
                        <div class="ipus-art-orbit ipus-art-orbit--inner"></div>

                        <div class="ipus-float-card ipus-float-card--top">
                            <span class="ipus-float-icon ipus-float-icon--yellow"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                            <span><small>Lebih dekat dengan</small><strong>Literasi Digital</strong></span>
                        </div>

                        <div class="ipus-phone">
                            <div class="ipus-phone-camera"></div>
                            <div class="ipus-phone-screen">
                                <div class="ipus-phone-topbar"><b>9:41</b><span><i class="fa-solid fa-signal"></i><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></span></div>
                                <div class="ipus-app-header">
                                    <div class="ipus-app-brandmark"><i class="fa-solid fa-book-open"></i></div>
                                    <div><strong>iPusSulteng</strong><small>Perpustakaan Digital</small></div>
                                    <i class="fa-solid fa-bars ipus-app-menu"></i>
                                </div>
                                <div class="ipus-app-welcome">
                                    <span>Halo, selamat membaca!</span>
                                    <strong>Satu aplikasi,<br>beragam inspirasi.</strong>
                                    <div class="ipus-app-welcome-decoration"><i class="fa-solid fa-book-open-reader"></i></div>
                                </div>
                                <div class="ipus-app-search"><i class="fa-solid fa-magnifying-glass"></i> Cari bacaan favoritmu...</div>
                                <div class="ipus-app-section-head"><strong>Jelajahi Koleksi</strong><span>Lihat semua <i class="fa-solid fa-chevron-right"></i></span></div>
                                <div class="ipus-book-shelf">
                                    <div class="ipus-book-cover ipus-book-cover--peach"><i class="fa-solid fa-lightbulb"></i><strong>IDE<br>BARU</strong><span>INSPIRASI</span></div>
                                    <div class="ipus-book-cover ipus-book-cover--blue"><i class="fa-solid fa-mountain-sun"></i><strong>ALAM &amp;<br>ILMU</strong><span>PENGETAHUAN</span></div>
                                    <div class="ipus-book-cover ipus-book-cover--green"><i class="fa-solid fa-seedling"></i><strong>TUMBUH<br>BERSAMA</strong><span>PENGEMBANGAN DIRI</span></div>
                                </div>
                                <div class="ipus-app-bottom"><span class="is-active"><i class="fa-solid fa-house"></i><small>Beranda</small></span><span><i class="fa-solid fa-book"></i><small>Koleksi</small></span><span><i class="fa-regular fa-bookmark"></i><small>Simpan</small></span><span><i class="fa-regular fa-user"></i><small>Profil</small></span></div>
                            </div>
                        </div>

                        <div class="ipus-float-card ipus-float-card--bottom">
                            <span class="ipus-float-icon ipus-float-icon--blue"><i class="fa-solid fa-book-open"></i></span>
                            <span><small>Perpustakaan</small><strong>Di mana pun kamu berada</strong></span>
                        </div>
                        <div class="ipus-art-star ipus-art-star--one"><i class="fa-solid fa-star"></i></div>
                        <div class="ipus-art-star ipus-art-star--two"><i class="fa-solid fa-star"></i></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Nilai utama: ringkas seperti institutional info-bar pada halaman Tugas dan Fungsi. --}}
        <div class="ipus-highlights" aria-label="Keunggulan layanan">
            <div class="container">
                <div class="ipus-highlight-panel">
                    <div class="ipus-highlight-item">
                        <span class="ipus-highlight-icon"><i class="fa-solid fa-clock" aria-hidden="true"></i></span>
                        <div><strong>Akses lebih fleksibel</strong><span>Menemani waktu baca sesuai aktivitasmu.</span></div>
                    </div>
                    <div class="ipus-highlight-item">
                        <span class="ipus-highlight-icon"><i class="fa-solid fa-mobile-screen" aria-hidden="true"></i></span>
                        <div><strong>Praktis lewat ponsel</strong><span>Koleksi bacaan hadir dalam satu aplikasi.</span></div>
                    </div>
                    <div class="ipus-highlight-item">
                        <span class="ipus-highlight-icon"><i class="fa-solid fa-people-group" aria-hidden="true"></i></span>
                        <div><strong>Dekat dengan masyarakat</strong><span>Memperluas jangkauan layanan literasi.</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Latar belakang inovasi --}}
        <section class="ipus-section ipus-background-section" id="tentang-ipussulteng" aria-labelledby="ipus-about-title">
            <div class="container">
                <div class="ipus-about-grid">
                    <div class="ipus-about-copy">
                        <span class="ipus-section-kicker"><span></span> MENGENAL INOVASI</span>
                        <h2 id="ipus-about-title">Mengapa <em>iPusSulteng</em> hadir?</h2>
                        <p class="ipus-lead">
                            Kebutuhan masyarakat akan informasi terus berkembang. Di sisi lain, jarak, waktu, dan
                            mobilitas dapat menjadi tantangan untuk datang langsung ke perpustakaan.
                        </p>
                        <p>
                            Sebagai bentuk transformasi layanan publik, DISPUSAKA Provinsi Sulawesi Tengah
                            menghadirkan iPusSulteng untuk memperluas akses terhadap bahan bacaan melalui
                            teknologi digital. Inovasi ini mendekatkan perpustakaan dengan aktivitas sehari-hari
                            masyarakat, sekaligus mendukung pembudayaan kegemaran membaca dan peningkatan literasi.
                        </p>
                        <a class="ipus-text-link" href="#cara-menggunakan">
                            Lihat cara mulai membaca <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div class="ipus-about-card">
                        <div class="ipus-about-topline"><span class="ipus-mini-dot"></span> DARI KEBUTUHAN MENJADI INOVASI</div>
                        <div class="ipus-about-graphic" aria-hidden="true">
                            <div class="ipus-graphic-node ipus-graphic-node--paper"><i class="fa-solid fa-book-open"></i><span>Perpustakaan</span></div>
                            <div class="ipus-graphic-connector"><span></span><i class="fa-solid fa-arrow-right"></i><span></span></div>
                            <div class="ipus-graphic-node ipus-graphic-node--digital"><i class="fa-solid fa-mobile-screen-button"></i><span>iPusSulteng</span></div>
                        </div>
                        <div class="ipus-about-quote"><i class="fa-solid fa-quote-left" aria-hidden="true"></i><p>Membawa akses bacaan lebih dekat ke kehidupan masyarakat melalui layanan perpustakaan digital.</p></div>
                        <div class="ipus-about-card-footer"><i class="fa-solid fa-building-columns" aria-hidden="true"></i> Inovasi pelayanan DISPUSAKA Provinsi Sulawesi Tengah</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tiga pilar manfaat --}}
        <section class="ipus-section ipus-benefits-section" aria-labelledby="ipus-benefits-title">
            <div class="container">
                <div class="ipus-section-heading ipus-section-heading--center">
                    <span class="ipus-section-kicker"><span></span> NILAI LAYANAN</span>
                    <h2 id="ipus-benefits-title">Satu inovasi, lebih banyak <em>kemudahan.</em></h2>
                    <p>Dirancang untuk membuat pengalaman menjelajahi bacaan digital terasa lebih sederhana dan mudah dijangkau.</p>
                </div>
                <div class="ipus-benefits-grid">
                    <article class="ipus-benefit-card">
                        <span class="ipus-benefit-number">01</span>
                        <div class="ipus-benefit-icon ipus-benefit-icon--blue"><i class="fa-solid fa-earth-asia" aria-hidden="true"></i></div>
                        <h3>Jangkauan lebih luas</h3>
                        <p>Memberi alternatif akses bacaan tanpa selalu harus datang langsung ke lokasi perpustakaan.</p>
                    </article>
                    <article class="ipus-benefit-card">
                        <span class="ipus-benefit-number">02</span>
                        <div class="ipus-benefit-icon ipus-benefit-icon--yellow"><i class="fa-solid fa-book-open-reader" aria-hidden="true"></i></div>
                        <h3>Belajar lebih fleksibel</h3>
                        <p>Menjadikan kegiatan membaca lebih mudah disesuaikan dengan kebutuhan dan rutinitas harian.</p>
                    </article>
                    <article class="ipus-benefit-card">
                        <span class="ipus-benefit-number">03</span>
                        <div class="ipus-benefit-icon ipus-benefit-icon--mint"><i class="fa-solid fa-heart-pulse" aria-hidden="true"></i></div>
                        <h3>Budaya literasi tumbuh</h3>
                        <p>Mendukung kebiasaan membaca melalui layanan perpustakaan yang relevan dengan era digital.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- Platform unduhan: tautan berbeda untuk Android dan iOS. --}}
        <section class="ipus-section ipus-download-section" id="unduh-aplikasi" aria-labelledby="ipus-download-title">
            <div class="container">
                <div class="ipus-download-shell">
                    <div class="ipus-download-intro">
                        <span class="ipus-section-kicker"><span></span> MULAI JELAJAHI BACAAN</span>
                        <h2 id="ipus-download-title">Unduh aplikasinya.<br><em>Mulai perjalanan literasimu.</em></h2>
                        <p>Pilih platform sesuai perangkat yang digunakan. Tautan berikut menuju kanal unduh aplikasi yang dirujuk oleh DISPUSAKA.</p>
                        <div class="ipus-availability"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Akses aplikasi melalui tautan resmi</div>
                    </div>
                    <div class="ipus-platform-grid">
                        <article class="ipus-platform-card">
                            <div class="ipus-platform-card-header"><span class="ipus-platform-icon ipus-platform-icon--play"><i class="fa-brands fa-google-play" aria-hidden="true"></i></span><span class="ipus-platform-tag">ANDROID</span></div>
                            <h3>Google Play Store</h3>
                            <p>Untuk ponsel dan tablet berbasis Android.</p>
                            <a href="{{ $ipusAndroidUrl }}" target="_blank" rel="noopener noreferrer" class="ipus-store-btn">
                                <span><small>Unduh melalui</small><strong>Google Play</strong></span>
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        </article>
                        <article class="ipus-platform-card">
                            <div class="ipus-platform-card-header"><span class="ipus-platform-icon ipus-platform-icon--apple"><i class="fa-brands fa-apple" aria-hidden="true"></i></span><span class="ipus-platform-tag">iOS</span></div>
                            <h3>App Store / iOS</h3>
                            <p>Untuk iPhone dan iPad melalui halaman unduh resmi SmartLib.</p>
                            <a href="{{ $ipusIosUrl }}" target="_blank" rel="noopener noreferrer" class="ipus-store-btn">
                                <span><small>Buka halaman unduh</small><strong>Untuk iOS</strong></span>
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pendaftaran akun dan aktivasi --}}
        <section class="ipus-section ipus-steps-section" id="cara-menggunakan" aria-labelledby="ipus-steps-title">
            <div class="container">
                <div class="ipus-steps-grid">
                    <div class="ipus-steps-content">
                        <span class="ipus-section-kicker"><span></span> CARA MENGGUNAKAN</span>
                        <h2 id="ipus-steps-title">Tiga langkah sederhana menuju <em>bacaanmu.</em></h2>
                        <p class="ipus-steps-intro">Ikuti alur berikut untuk mulai menggunakan layanan iPusSulteng.</p>
                        <ol class="ipus-step-list">
                            <li><span class="ipus-step-index">01</span><div><h3>Unduh aplikasi</h3><p>Pasang iPusSulteng melalui tautan Android atau iOS di atas.</p></div></li>
                            <li><span class="ipus-step-index">02</span><div><h3>Ajukan pendaftaran akun</h3><p>Isi formulir pendaftaran iPusSulteng yang disediakan layanan perpustakaan.</p></div></li>
                            <li><span class="ipus-step-index">03</span><div><h3>Ikuti arahan aktivasi</h3><p>Ikuti petunjuk petugas, kemudian masuk ke aplikasi untuk menjelajahi koleksi yang tersedia.</p></div></li>
                        </ol>
                        <a class="ipus-guide-link" href="{{ $ipusGuideUrl }}" target="_blank" rel="noopener noreferrer"><i class="fa-regular fa-file-lines" aria-hidden="true"></i> Lihat panduan penggunaan resmi <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    </div>
                    <aside class="ipus-register-card" id="pendaftaran-akun" aria-labelledby="ipus-register-title">
                        <div class="ipus-register-graphic" aria-hidden="true"><span class="ipus-register-ring"></span><i class="fa-solid fa-id-card"></i><span class="ipus-register-check"><i class="fa-solid fa-check"></i></span></div>
                        <span class="ipus-register-kicker">PENDAFTARAN AKUN</span>
                        <h3 id="ipus-register-title">Belum punya akun iPusSulteng?</h3>
                        <p>Lengkapi formulir pendaftaran agar dapat memperoleh akses ke layanan perpustakaan digital sesuai ketentuan yang berlaku.</p>
                        <a href="{{ $ipusRegistrationUrl }}" target="_blank" rel="noopener noreferrer" class="ipus-btn ipus-btn--yellow ipus-register-button">Isi Formulir Pendaftaran <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                        <div class="ipus-register-divider"><span>Butuh bantuan?</span></div>
                        <a class="ipus-register-support" href="{{ $ipusWhatsAppUrl }}" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span>Hubungi petugas layanan <strong>0823-2022-2290</strong></span><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </aside>
                </div>
            </div>
        </section>

        {{-- Informasi penting dengan detail native, tetap dapat digunakan tanpa JS. --}}
        <section class="ipus-section ipus-faq-section" aria-labelledby="ipus-faq-title">
            <div class="container">
                <div class="ipus-faq-grid">
                    <div class="ipus-faq-heading">
                        <span class="ipus-section-kicker"><span></span> INFORMASI PENTING</span>
                        <h2 id="ipus-faq-title">Yang sering <em>ditanyakan.</em></h2>
                        <p>Beberapa informasi singkat sebelum menggunakan iPusSulteng.</p>
                    </div>
                    <div class="ipus-faq-list">
                        <details class="ipus-faq-item"><summary>Bagaimana cara mendapatkan akun iPusSulteng?<i class="fa-solid fa-plus" aria-hidden="true"></i></summary><p>Unduh aplikasinya, lalu isi formulir pendaftaran yang tersedia pada halaman ini. Ikuti petunjuk aktivasi atau informasi lanjutan dari petugas layanan.</p></details>
                        <details class="ipus-faq-item"><summary>Apakah layanan dapat diakses melalui Android dan iPhone?<i class="fa-solid fa-plus" aria-hidden="true"></i></summary><p>Ya. Tautan Android tersedia melalui Google Play, sedangkan pengguna iPhone dan iPad dapat menuju laman unduhan iOS resmi SmartLib.</p></details>
                        <details class="ipus-faq-item"><summary>Apakah ada ketentuan peminjaman koleksi?<i class="fa-solid fa-plus" aria-hidden="true"></i></summary><p>Ya. Akses, jumlah peminjaman, durasi baca, dan cakupan wilayah mengikuti ketentuan layanan iPusSulteng yang berlaku. Informasi terkini dapat ditanyakan kepada petugas.</p></details>
                    </div>
                </div>
            </div>
        </section>

        <section class="ipus-bottom-cta" aria-label="Ajakan mengunduh iPusSulteng">
            <div class="container">
                <div class="ipus-bottom-cta-inner">
                    <div class="ipus-bottom-cta-symbol" aria-hidden="true"><i class="fa-solid fa-book-open"></i></div>
                    <div><span>PERPUSTAKAAN DIGITAL SULAWESI TENGAH</span><h2>Satu langkah kecil untuk kebiasaan membaca yang lebih besar.</h2></div>
                    <a href="#unduh-aplikasi" class="ipus-btn ipus-btn--yellow">Unduh iPusSulteng <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </section>
    </div>
@endsection
