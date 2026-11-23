@extends('home.layouts.app')

@section('title', 'Struktur Organisasi - Dispusaka Prov. Sulteng')

@section('contents')


    <!-- HERO -->
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
                <span aria-current="page">Struktur Organisasi</span>
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
                        Mengenal <span>Struktur Organisasi</span>
                    </h1>

                    <p class="history-hero-description">
                        Struktur organisasi menggambarkan sistem koordinasi, pembagian fungsi, serta hubungan kerja antar
                        bagian dalam mendukung
                        pelayanan dan pencapaian tujuan institusi.
                    </p>

                    <div class="history-hero-actions">
                        <a href="#struktur-organisasi" class="history-primary-button">
                            <span>Lihat Struktur Organisasi</span>
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

    <!-- STRUCTURE IMAGE -->
    <section class="structure-area" id="struktur-organisasi">
        <div class="container">

            <div class="org-structure-top">
                <div class="org-structure-heading">
                    <div class="org-structure-kicker">
                        <span class="org-kicker-dot"></span>
                        <span>LANDASAN STRUKTURAL</span>
                    </div>

                    <h2>Bagan dan Tata Kelola Organisasi</h2>

                    <p>
                        Struktur organisasi menggambarkan alur koordinasi, pembagian fungsi, serta hubungan kerja
                        antar unit dalam mendukung pelayanan, pengelolaan, dan pencapaian tujuan institusi.
                    </p>
                </div>

                <div class="org-structure-focus">
                    <div class="org-structure-focus-icon">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <div class="org-structure-focus-text">
                        <span>FOKUS UTAMA</span>
                        <strong>Struktur & Koordinasi</strong>
                    </div>
                </div>
            </div>

            <div class="org-structure-highlight">
                <div class="org-structure-highlight-icon">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>

                <span class="org-structure-highlight-label">BAGAN ORGANISASI</span>

                <h3>Struktur Organisasi Dispusaka Provinsi Sulawesi Tengah</h3>

                <div class="org-structure-divider"></div>

                <p class="org-structure-highlight-text">
                    Bagan organisasi ini menunjukkan susunan kepemimpinan, unit kerja, serta pola koordinasi
                    antar bagian untuk memastikan pelaksanaan tugas berjalan efektif, terarah, dan terintegrasi.
                </p>

                <div class="org-structure-highlight-number">01</div>
                <div class="org-structure-highlight-circle"></div>
            </div>

            @if($struktur && $struktur->gambar)
                <div class="structure-viewer">
                    <img src="{{ asset('uploads_files/profil/' . $struktur->gambar) }}" class="structure-image"
                        alt="Bagan Organisasi" onclick="openStructureModal(this.src)">

                    <div class="zoom-info">
                        <i class="fa-solid fa-expand"></i>
                        <span>Klik gambar untuk memperbesar detail struktur organisasi</span>
                    </div>
                </div>
            @else
                <div class="structure-empty">
                    <i class="fa-solid fa-folder-open"></i>
                    <h3>Bagan organisasi belum tersedia</h3>
                    <p>Silakan unggah gambar struktur organisasi untuk ditampilkan pada halaman ini.</p>
                </div>
            @endif

        </div>
    </section>

    <!-- MODAL VIEWER -->
    <div id="structureModal" class="structure-modal">
        <div class="viewer-toolbar">
            <button onclick="zoomIn()">+</button>
            <button onclick="zoomOut()">-</button>
            <button onclick="resetZoom()">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
        <span class="structure-close" onclick="closeStructureModal()">
            &times;
        </span>

        <div class="image-container">
            <img id="structureModalImage" class="structure-modal-image" draggable="false">
        </div>
    </div>

    <script>
        let scale = 1;
        let translateX = 0;
        let translateY = 0;
        let drag = false;
        let startX;
        let startY;

        const modalImage = document.getElementById('structureModalImage');

        function openStructureModal(src) {
            document
                .getElementById('structureModal')
                .classList.add('active');
            modalImage.src = src;
            resetZoom();
        }

        function closeStructureModal() {
            document
                .getElementById('structureModal')
                .classList.remove('active');
        }

        function updateTransform() {
            modalImage.style.transform = `translate(${translateX}px,${translateY}px)scale(${scale})`;
        }

        function zoomIn() {
            scale += 0.2;
            updateTransform();
        }

        function zoomOut() {
            if (scale > 0.5) {
                scale -= 0.2;
            }
            updateTransform();
        }

        function resetZoom() {
            scale = 1;
            translateX = 0;
            translateY = 0;
            updateTransform();
        }

        modalImage.onwheel = function (e) {
            e.preventDefault();
            if (e.deltaY < 0) {
                scale += 0.1;
            } else {
                if (scale > 0.5)
                    scale -= 0.1;
            }
            updateTransform();
        }

        modalImage.onmousedown = function (e) {
            drag = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
        }

        window.onmousemove = function (e) {
            if (!drag) return;
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            updateTransform();
        }

        window.onmouseup = function () {
            drag = false;
        }
    </script>
@endsection