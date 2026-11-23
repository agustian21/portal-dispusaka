@extends('home.layouts.app')

@section('title', 'Tugas dan Tanggung Jawab PPID - Dispusaka Prov. Sulteng')

@push('styles')
    @vite('resources/css/visimisi.css')
@endpush

@section('contents')
    <div class="vm-page">
        <section class="vm-hero" aria-labelledby="tugas-hero-title">
            <div class="vm-hero-pattern" aria-hidden="true"></div>
            <div class="vm-orb vm-orb-one" aria-hidden="true"></div>
            <div class="vm-orb vm-orb-two" aria-hidden="true"></div>
            <div class="container">
                <nav class="vm-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i><span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right vm-breadcrumb-separator" aria-hidden="true"></i>
                    <span>PPID</span>
                    <i class="fa-solid fa-chevron-right vm-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">Tugas dan Tanggung Jawab</span>
                </nav>

                <div class="vm-hero-grid">
                    <div class="vm-hero-copy">
                        <div class="vm-hero-eyebrow">
                            <span class="vm-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-solid fa-list-check"></i>
                            </span>
                            <span>Pengelolaan Informasi Publik</span>
                        </div>
                        <h1 id="tugas-hero-title">Tugas yang jelas. <span>Tanggung jawab yang terukur.</span></h1>
                        <p class="vm-hero-description">
                            Tugas dan tanggung jawab PPID DISPUSAKA Provinsi Sulawesi Tengah menjadi dasar pelaksanaan
                            pengelolaan dan pelayanan informasi publik pada perangkat daerah.
                        </p>
                        <div class="vm-hero-actions">
                            <a href="#tugas-ppid" class="vm-primary-button">
                                <span>Lihat Tugas PPID</span>
                                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                            </a>
                            <div class="vm-hero-points" aria-label="Prinsip pelaksanaan tugas PPID">
                                <span>
                                    <i class="fa-solid fa-check-double" aria-hidden="true"></i>Akuntabel</span>
                                <span>
                                    <i class="fa-solid fa-people-arrows" aria-hidden="true"></i>Terkoordinasi
                                </span>
                                <span><i class="fa-solid fa-clock" aria-hidden="true"></i>Responsif</span>
                            </div>
                        </div>
                    </div>

                    <div class="vm-hero-visual" aria-hidden="true">
                        <div class="vm-visual-ring vm-visual-ring-one"></div>
                        <div class="vm-visual-ring vm-visual-ring-two"></div>
                        <div class="vm-visual-card">
                            <div class="vm-visual-card-head">
                                <span class="vm-visual-status"><span></span>PPID DISPUSAKA</span>
                                <i class="fa-solid fa-sitemap"></i>
                            </div>
                            <div class="vm-visual-main">
                                <span class="vm-visual-main-icon"><i class="fa-solid fa-list-check"></i></span>
                                <div>
                                    <small>Fokus pelaksanaan</small>
                                    <strong>
                                        Pengelolaan dan pelayanan informasi publik yang terkoordinasi.
                                    </strong>
                                </div>
                            </div>
                            <div class="vm-visual-route">
                                <span class="is-active"><i class="fa-solid fa-database"></i></span>
                                <div></div>
                                <span><i class="fa-solid fa-gears"></i></span>
                                <div></div>
                                <span><i class="fa-solid fa-users"></i></span>
                            </div>
                            <div class="vm-visual-footer">
                                <strong>Tugas PPID</strong>
                                <small>pengelolaan informasi publik</small>
                            </div>
                        </div>

                        <div class="vm-floating-card vm-floating-card-one">
                            <i class="fa-solid fa-folder-open"></i>
                            <div>
                                <small>Informasi publik</small>
                                <strong>Terkelola</strong>
                            </div>
                        </div>

                        <div class="vm-floating-card vm-floating-card-two">
                            <i class="fa-solid fa-handshake"></i>
                            <div>
                                <small>Pelayanan</small>
                                <strong>Terkoordinasi</strong>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="tugas-ppid" class="vm-content-section" aria-labelledby="tugas-content-title">
            <div class="container">
                <div class="vm-section-heading">
                    <div>
                        <span class="vm-section-eyebrow">
                            <i class="fa-solid fa-circle-nodes" aria-hidden="true"></i>Peran PPID
                        </span>
                        <h2 id="tugas-content-title">
                            Tugas dan tanggung jawab dalam pelayanan informasi publik.
                        </h2>
                        <p>
                            PPID menjalankan fungsi pengelolaan informasi publik secara terstruktur. Pelaksana PPID
                            mendukung pelaksanaan tugas tersebut pada lingkup perangkat daerah.
                        </p>
                    </div>

                    @if ($tugasppid?->updated_at)
                        <div class="vm-update-badge">
                            <span class="vm-update-icon" aria-hidden="true">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </span>
                            <div>
                                <small>Terakhir diperbarui</small>
                                <strong>
                                    {{ $tugasppid->updated_at->format('d/m/Y') }}
                                </strong>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($tugasppid)
                    <div class="vm-main-grid">
                        <article class="vm-vision-card">
                            <div class="vm-card-decoration" aria-hidden="true"></div>
                            <header class="vm-vision-header">
                                <span class="vm-card-icon" aria-hidden="true">
                                    <i class="fa-solid fa-bullseye"></i>
                                </span>
                                <div>
                                    <span class="vm-card-label">Tanggung Jawab Utama</span>
                                    <h3>Tugas Utama PPID</h3>
                                </div>
                            </header>

                            <div class="vm-vision-content">
                                @if (count($tugasUtamaItems) > 0)
                                    <div style=" width: 100%; display: grid; gap: 18px;">
                                        @foreach ($tugasUtamaItems as $item)
                                            <div
                                                style=" display: grid; grid-template-columns: 36px 1fr; align-items: start; gap: 12px; ">
                                                <span
                                                    style="width: 36px; height: 36px; display: grid; place-items: center; flex: 0 0 auto; border-radius: 11px; background: rgba(255, 255, 255, 0.10); color: var(--gold); font-size: 9px; font-weight: 800;"
                                                    aria-hidden="true">
                                                    {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                                <p style="margin: 0; font-size: 14px; line-height: 1.75; font-weight: 600;">
                                                    {{ $item }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>

                                @else
                                    <p class="vm-content-placeholder">Informasi tugas utama PPID belum tersedia.</p>
                                @endif
                            </div>
                        </article>

                        <article class="vm-mission-card">
                            <header class="vm-mission-header">
                                <div class="vm-mission-heading">
                                    <span class="vm-card-icon vm-card-icon-light" aria-hidden="true">
                                        <i class="fa-solid fa-gears"></i>
                                    </span>
                                    <div>
                                        <span class="vm-card-label">Pelaksanaan Operasional</span>
                                        <h3>Tugas Pelaksana PPID</h3>
                                    </div>
                                </div>

                                @if (count($tugasPelaksanaItems) > 0)
                                    <span class="vm-mission-count">
                                        {{ count($tugasPelaksanaItems) }}
                                        tugas
                                    </span>
                                @endif
                            </header>

                            @if (count($tugasPelaksanaItems) > 0)
                                <ol class="vm-mission-list">
                                    @foreach ($tugasPelaksanaItems as $item)
                                        <li>
                                            <span class="vm-mission-number" aria-hidden="true">
                                                {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <div class="vm-mission-text">
                                                <span>Tugas {{ $loop->iteration }}</span>
                                                <p>{{ $item }}</p>
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
                                        <strong>Tugas pelaksana belum tersedia</strong>
                                        <p>Informasi tugas pelaksana PPID belum dipublikasikan pada sistem.</p>
                                    </div>
                                </div>
                            @endif
                        </article>

                    </div>

                    <div class="vm-principle-strip">
                        <div class="vm-principle-intro">
                            <span>Pelaksanaan tugas</span>
                            <strong>
                                Pengelolaan informasi publik dilaksanakan melalui koordinasi, dokumentasi, dan pelayanan yang
                                dapat dipertanggungjawabkan.
                            </strong>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true"><i class="fa-solid fa-people-arrows"></i></span>
                            <div>
                                <strong>Koordinasi</strong>
                                <small>Pelaksanaan tugas terhubung antar unit kerja.</small>
                            </div>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true"><i class="fa-solid fa-folder-tree"></i></span>
                            <div>
                                <strong>Dokumentasi</strong>
                                <small>Informasi dikelola secara sistematis.</small>
                            </div>
                        </div>

                        <div class="vm-principle-item">
                            <span aria-hidden="true"><i class="fa-solid fa-user-check"></i></span>
                            <div>
                                <strong>Pelayanan</strong>
                                <small>Informasi tersedia untuk kebutuhan publik.</small>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="vm-empty-state">
                        <span class="vm-empty-icon" aria-hidden="true">
                            <i class="fa-solid fa-list-check"></i>
                        </span>
                        <div>
                            <span class="vm-empty-label">Informasi belum tersedia</span>
                            <h3>Tugas dan Tanggung Jawab PPID sedang dipersiapkan.</h3>
                            <p>
                                Data tugas PPID belum tersedia pada sistem. Informasi akan tampil secara otomatis setelah data
                                dipublikasikan oleh pengelola.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection