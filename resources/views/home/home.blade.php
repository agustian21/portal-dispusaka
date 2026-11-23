@extends('home.layouts.app')
@section('title', 'Beranda - DISPUSAKA Provinsi Sulawesi Tengah')

@section('contents')
    <section aria-label="Berita trending DISPUSAKA" class="trending-news">
        <div class="container trending-shell">
            <div class="trending-label">
                <i class="fa-solid fa-bolt"></i>
                <span>Berita Trending</span>
            </div>
            <div aria-live="off" class="trending-window">
                <div class="trending-track">
                    <div class="trending-group">
                        @foreach ($beritas as $berita)
                            <a class="trending-item" href="#berita">
                                <time
                                    datetime="{{ $berita->tgl->format('Y-m-d') }}">{{ $berita->tgl->format('d M Y') }}</time>
                                <i class="fa-solid fa-circle"></i>
                                <span>{{ $berita->judul }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section aria-label="Slider informasi DISPUSAKA" class="hero hero-slider-section" id="beranda">
        <div class="container slider-container">
            <div class="hero-carousel" id="heroCarousel">
                @foreach ($sliders as $index => $slider)
                    <div class="hero-slide">
                        <img alt="{{ $slider->nm_slide }}" src="{{ asset('uploads_files/slider/' . $slider->gambar) }}" />
                    </div>
                @endforeach
                <button aria-label="Slide sebelumnya" class="slider-arrow slider-prev" type="button">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button aria-label="Slide berikutnya" class="slider-arrow slider-next" type="button">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <div class="slider-status">
                    <span class="slider-counter">
                        <b id="currentSlide">01</b>
                        <em>/</em>
                        <span>{{ str_pad($sliders->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    </span>
                    <div class="slider-dots" id="sliderDots">
                        @foreach ($sliders as $index => $slider)
                            <button aria-label="Tampilkan slide {{ $index + 1 }}"
                                class="slider-dot {{ $index == 0 ? 'active' : '' }}" data-slide="{{ $index }}"
                                type="button">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container quick-search-wrap">
        <form class="quick-search" onsubmit="event.preventDefault(); alert('Pencarian: Masih dalam pengembangan.');">
            <div class="search-field">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input aria-label="Pencarian situs" placeholder="Cari berita, layanan, informasi, atau dokumen..."
                    type="search" />
            </div>
            <button class="search-btn" type="submit">Cari di Portal</button>
        </form>
    </div>

    <section class="services" id="layanan">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Layanan Digital</div>
                    <h2>Akses layanan utama lebih cepat</h2>
                    <p>Struktur layanan tetap mengikuti portal awal, dengan tampilan yang lebih ringkas, konsisten,
                        dan mudah digunakan.</p>
                </div>
            </div>
            <div class="service-grid">
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                    <h3>OPAC</h3>
                    <p>Telusuri koleksi perpustakaan melalui Online Public Access Catalog.</p>
                    <a href="https://inlislite.sultengprov.go.id" rel="noopener" target="_blank">Buka OPAC <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-id-card"></i></div>
                    <h3>Anggota Perpustakaan</h3>
                    <p>Akses formulir pendaftaran untuk menjadi anggota perpustakaan.</p>
                    <a href="#" target="_blank">Daftar Anggota <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                    <h3>Survey Kepuasan Masyarakat</h3>
                    <p>Bantu kami meningkatkan layanan dengan memberikan feedback tentang pengalaman Anda.</p>
                    <a href="https://skm.go.id/share/instansi/cfdf6d4e-655d-47e6-b42e-4468aa846fcf/1" target="_blank">Buka
                        Formulir <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                    <h3>I Pus Sulteng</h3>
                    <p>Nikmati koleksi digital DISPUSAKA melalui perangkat Android maupun iOS.</p>
                    <a href="{{ route('ipussulteng') }}" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Srikandi Arsip</h3>
                    <p>Informasi dan tautan tentang program srikandi.</p>
                    <a href="https://srikandi.arsip.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <h3>JIKN ANRI</h3>
                    <p>Informasi dan tautan tentang program jikn anri.</p>
                    <a href="https://jikn.anri.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-user-check"></i></div>
                    <h3>Akreditasi Perpustakaan</h3>
                    <p>Informasi dan tautan tentang program akreditasi perpustakaan.</p>
                    <a href="https://akreditasi.perpusnas.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-book"></i></div>
                    <h3>e-Resources</h3>
                    <p>Informasi dan tautan tentang program e-resources.</p>
                    <a href="https://e-resources.perpusnas.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-gavel"></i></div>
                    <h3>Khastara Perpusnas RI</h3>
                    <p>Informasi dan tautan tentang program khastara.</p>
                    <a href="https://khastara.perpusnas.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="service-card">
                    <div class="service-icon"><i class="fa-solid fa-laptop"></i></div>
                    <h3>Inlislite Perpusnas RI</h3>
                    <p>Informasi dan tautan tentang program Inlislite.</p>
                    <a href="https://inlislite.perpusnas.go.id/" rel="noopener" target="_blank">Akses Website <i
                            class="fa-solid fa-arrow-right"></i></a>
                </article>
            </div>
        </div>
    </section>

    <section aria-labelledby="officialsTitle" class="officials-section" id="pejabat">
        <div class="container">
            <div class="officials-intro">
                <div class="section-head">
                    <div>
                        <div class="eyebrow">Profil Organisasi</div>
                        <h2 id="officialsTitle">Pejabat Struktural &amp; Fungsional</h2>
                        <p>Kenali jajaran pimpinan dan pejabat yang mendukung penyelenggaraan layanan perpustakaan
                            dan kearsipan Provinsi Sulawesi Tengah.</p>
                    </div>
                </div>
                <div class="officials-intro-note"><i class="fa-solid fa-circle-check"></i>Data disusun berdasarkan
                    struktur organisasi resmi DISPUSAKA Provinsi Sulawesi Tengah.</div>
            </div>
            <div class="official-leadership">
                @foreach ($kepalaDinas as $pejabat)
                    <article class="official-leader">
                        <div class="official-avatar"><img alt="Foto {{ $pejabat->nama }}"
                                src="{{ asset('uploads_files/pejabat/' . $pejabat->foto) }}" loading="lazy" />
                        </div>
                        <div class="official-leader-content">
                            <span class="official-role">{{ $pejabat->jabatan }}</span>
                            <h3 class="official-name">{{ $pejabat->nama }}</h3>
                            <div class="official-nip"><b>NIP</b>{{ $pejabat->nip }}</div>
                        </div>
                    </article>
                @endforeach
                @foreach ($sekretaris as $pejabat)
                    <article class="official-leader secondary">
                        <div class="official-avatar"><img alt="Foto {{ $pejabat->nama }}"
                                src="{{ asset('uploads_files/pejabat/' . $pejabat->foto) }}" loading="lazy">
                        </div>
                        <div class="official-leader-content">
                            <span class="official-role">Sekretaris Dinas</span>
                            <h3 class="official-name">{{ $pejabat->nama }}</h3>
                            <div class="official-nip"><b>NIP</b>{{ $pejabat->nip }}</div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="official-group" id="data-bidang">
                <div class="official-group-head">
                    <h3 class="official-group-title"><span><i class="fa-solid fa-layer-group"></i></span>Kepala
                        Bidang</h3>
                    <div class="official-group-count">5 Bidang</div>
                </div>
                <div class="official-grid">
                    @foreach ($kepalaBidang as $pejabat)
                        <article class="official-card">
                            <div class="official-card-photo">
                                <img alt="Foto {{ $pejabat->nama }}"
                                    src="{{ asset('uploads_files/pejabat/' . $pejabat->foto) }}" loading="lazy">
                                <span aria-hidden="true" class="photo-badge">
                                    <i class="fa-solid fa-box-archive"></i>
                                </span>
                            </div>
                            <span class="card-role">Kepala {{ $pejabat->namabidang?->nama_bidang ?? '-' }}</span>
                            <h4>{{ $pejabat->nama }}</h4>
                            <p><b>NIP.</b>{{ $pejabat->nip }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="official-support">
                <div class="official-group" style="margin-top:0">
                    <div class="official-group-head">
                        <h3 class="official-group-title"><span><i class="fa-solid fa-sitemap"></i></span>Kepala Sub
                            Bagian</h3>
                        <div class="official-group-count">3 Sub Bagian</div>
                    </div>
                    <div class="subbag-grid">
                        @foreach ($kasubag as $pejabat)
                            <article class="subbag-card">
                                <div class="subbag-photo"><img alt="Foto {{ $pejabat->nama }}"
                                        src="{{ asset('uploads_files/pejabat/' . $pejabat->foto) }}" loading="lazy"><span
                                        aria-hidden="true" class="photo-badge"><i
                                            class="fa-solid fa-chart-line"></i></span>
                                </div>
                                <div><span>Kepala {{ $pejabat->namabidang?->nama_bidang ?? '-' }}</span>
                                    <h4>{{ $pejabat->nama }}</h4>
                                    <p>NIP {{ $pejabat->nip }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="official-group" style="margin-top:0">
                    <div class="official-group-head">
                        <h3 class="official-group-title"><span><i class="fa-solid fa-medal"></i></span>Fungsional
                            Madya</h3>
                    </div>
                    <div class="functional-box">
                        <div>
                            <div class="functional-label">Kelompok Jabatan Fungsional</div>
                            <div class="functional-item"><i class="fa-solid fa-book"></i>
                                <div><strong>Pustakawan</strong><small>Jabatan fungsional
                                        perpustakaan</small></div>
                            </div>
                            <div class="functional-item"><i class="fa-solid fa-file-shield"></i>
                                <div><strong>Arsiparis</strong><small>Jabatan fungsional
                                        kearsipan</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="official-source"><i class="fa-solid fa-circle-info"></i><span>Sumber data dan foto pejabat
                    struktural: Struktur Organisasi DISPUSAKA Provinsi Sulawesi Tengah — <a
                        href="https://dispusarda.sultengprov.go.id/profil_dinas/19d46ac3-1f02-4c7b-84a8-5ec7f97baf53"
                        rel="noopener" target="_blank">lihat struktur resmi</a>.</span></div>
        </div>
    </section>

    <section id="berita">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Berita Kegiatan</div>
                    <h2>Kabar terbaru DISPUSAKA Sulteng</h2>
                    <p>Informasi kegiatan perpustakaan, kearsipan, literasi, koordinasi, dan pelayanan publik.</p>
                </div>
                <a class="link-more" href="https://dispusarda.sultengprov.go.id/home" rel="noopener"
                    target="_blank">Lihat
                    semua berita <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
            <div class="news-grid">
                @foreach ($beritas as $index => $berita)
                    <article class="news-card {{ $index == 0 ? 'featured' : '' }}">
                        <div class="news-thumb">
                            @if ($berita->gambar)
                                <img src="{{ asset('uploads_files/berita/' . $berita->gambar) }}"
                                    alt="{{ $berita->judul }}" loading="lazy">
                            @endif
                            <div class="news-date">
                                {{ $berita->tgl->translatedFormat('d F Y') }}
                            </div>
                        </div>

                        <div class="news-body">
                            <span class="news-cat">Berita</span>
                            <h3>
                                <a href="{{ route('berita-dispusaka.show', $berita->slug_judul) }}">
                                    {{ $berita->judul }}
                                </a>
                            </h3>
                            <p>
                                {{ Str::limit(strip_tags($berita->description ?? $berita->isi), 120) }}
                            </p>
                            <div class="news-meta">
                                <span>
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $berita->tgl->format('d-m-Y') }}
                                </span>
                                <span>
                                    <i class="fa-regular fa-newspaper"></i> DISPUSAKA
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="video">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Video Kegiatan</div>
                    <h2>Aktivitas dalam format audiovisual</h2>
                    <p>Dokumentasi kegiatan DISPUSAKA Provinsi Sulawesi Tengah.</p>
                </div>
                <a class="link-more" href="#">
                    Selengkapnya <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

            <div class="video-modern-grid">
                @php
                    $mainVideo = $videos->first();
                    function youtubeId($url)
                    {
                        if (!$url) {
                            return null;
                        }
                        preg_match(
                            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([^&?\/]+)/',
                            $url,
                            $matches,
                        );
                        return $matches[1] ?? null;
                    }
                @endphp

                @if ($mainVideo)
                    <div class="video-feature" onclick="openYoutube('{{ youtubeId($mainVideo->linkvideo) }}')">
                        <img src="https://img.youtube.com/vi/{{ youtubeId($mainVideo->linkvideo) }}/hqdefault.jpg"
                            alt="{{ $mainVideo->judul }}">
                        <div class="video-overlay"></div>
                        <button class="play-modern"><i class="fa-solid fa-play"></i></button>
                        <div class="video-info">
                            <span><i class="fa-brands fa-youtube"></i>Video Pilihan</span>
                            <h3>{{ $mainVideo->judul }}</h3>
                        </div>
                    </div>
                @endif

                <div class="video-side">
                    @foreach ($videos->skip(1) as $video)
                        <article class="video-card" onclick="openYoutube('{{ youtubeId($video->linkvideo) }}')">
                            <div class="video-thumb">
                                <img src="https://img.youtube.com/vi/{{ youtubeId($video->linkvideo) }}/hqdefault.jpg">
                                <span><i class="fa-solid fa-play"></i></span>
                            </div>
                            <div class="video-text">
                                <h4>{{ $video->judul }}</h4>
                                <small>Video kegiatan</small>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- VIDEO MODAL -->
    <div id="youtubeModal" class="youtube-modal">
        <div class="youtube-box">
            <button onclick="closeYoutube()"><i class="fa-solid fa-xmark"></i></button>
            <iframe id="youtubeFrame" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>

    <section class="alt-section" id="informasi">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Pamflet Informasi</div>
                    <h2>Informasi penting untuk masyarakat</h2>
                    <p>Konten pamflet situs awal tetap dipertahankan sebagai kategori tersendiri agar mudah dipindai
                        pengguna.</p>
                </div>
                <a class="link-more" href="#">Selengkapnya <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
            <div class="info-grid">
                @foreach ($pamflets as $pamflet)
                    <article class="info-card">
                        <div class="info-poster">
                            @if (is_array($pamflet->gambar) && !empty($pamflet->gambar))
                                <img src="{{ asset('uploads_files/pamflet/' . $pamflet->gambar[0]) }}"
                                    alt="{{ $pamflet->nm_pamflet }}" loading="lazy">
                            @endif
                        </div>
                        <div class="info-body"><span>{{ $pamflet->created_at->format('d-m-Y') }}</span>
                            <h4>{{ $pamflet->nm_pamflet }}</h4>
                        </div>
                    </article>
                @endforeach

            </div>
        </div>
    </section>

    <section class="cta" id="kontak">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Butuh informasi atau bantuan layanan?</h2>
                    <p>Hubungi DISPUSAKA Provinsi Sulawesi Tengah untuk informasi perpustakaan, kearsipan,
                        keanggotaan, dan layanan publik lainnya.</p>
                </div>
                <a class="btn btn-primary" href="#"><i class="fa-regular fa-message"></i>Hubungi Kami</a>
            </div>
        </div>
    </section>

    <section aria-labelledby="relatedLinksTitle" class="related-links" id="link-terkait">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="eyebrow">Pranala Resmi</div>
                    <h2 id="relatedLinksTitle">Link Terkait</h2>
                    <p>Akses cepat ke layanan dan portal resmi yang berkaitan dengan perpustakaan, kearsipan,
                        regulasi, serta pelayanan publik.</p>
                </div>
            </div>
            <div class="related-links-grid">
                <a class="related-link-card" href="https://kws.kpk.go.id/" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-file-contract"></i></div>
                    <div><strong>Lapor KPK</strong><span>Buka portal <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
                <a class="related-link-card" href="https://www.bkn.go.id/" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-user"></i></div>
                    <div><strong>Badan Kepegawaian Negara RI</strong><span>Buka portal <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
                <a class="related-link-card" href="https://sultengprov.go.id/" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-flag"></i></div>
                    <div><strong>Provinsi Sulawesi Tengah</strong><span>Buka portal <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
                <a class="related-link-card" href="https://perpusnas.go.id" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-book"></i></div>
                    <div><strong>Perpustakaan Nasional RI</strong><span>Buka portal <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
                <a class="related-link-card" href="https://anri.go.id" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-box-archive"></i></div>
                    <div><strong>Arsip Nasional RI</strong><span>Buka portal <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
                <a class="related-link-card" href="https://www.lapor.go.id/" rel="noopener" target="_blank">
                    <div class="related-link-icon"><i class="fa-solid fa-paper-plane"></i></div>
                    <div><strong>SP4N LAPOR!</strong><span>Buka layanan <i
                                class="fa-solid fa-arrow-up-right-from-square"></i></span></div>
                </a>
            </div>
        </div>
    </section>

    <section class="visitor-stats-section" aria-label="Statistik pengunjung website">
        <div class="container">
            <div class="visitor-stats-card">
                {{-- Bagian utama --}}
                <div class="visitor-stats-main">
                    <div class="visitor-stats-heading">
                        <span class="visitor-stats-indicator"></span>
                        STATISTIK PENGUNJUNG
                    </div>
                    <div class="visitor-stats-content">
                        <div class="visitor-stats-metrics">
                            {{-- Pengunjung hari ini --}}
                            <div class="visitor-stats-info">
                                <p class="visitor-stats-label">
                                    Pengunjung Hari Ini
                                </p>
                                <div class="visitor-stats-number">
                                    {{ number_format($totalVisitorsToday ?? 0, 0, ',', '.') }}
                                </div>
                                <p class="visitor-stats-description">
                                    Pengunjung yang mengakses portal hari ini.
                                </p>
                            </div>

                            {{-- Total keseluruhan --}}
                            <div class="visitor-stats-info visitor-total-all">
                                <p class="visitor-stats-label">
                                    Total Pengunjung Keseluruhan
                                </p>
                                <div class="visitor-stats-number">
                                    {{ number_format($totalVisitorsAllTime ?? 0, 0, ',', '.') }}
                                </div>
                                <p class="visitor-stats-description">
                                    Pengunjung yang pernah mengakses portal.
                                </p>
                            </div>
                        </div>
                        <div class="visitor-stats-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
                {{-- Informasi tambahan --}}
                <div class="visitor-stats-side">
                    <div class="visitor-stats-date">
                        <div class="visitor-stats-date-icon">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>
                        <div>
                            <span>Tanggal Pemantauan</span>
                            <strong>
                                {{ now()->translatedFormat('d F Y') }}
                            </strong>
                        </div>
                    </div>
                    <div class="visitor-stats-divider"></div>
                    <div class="visitor-stats-note">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Terima kasih telah menggunakan portal kami.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
