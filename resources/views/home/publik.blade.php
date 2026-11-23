@extends('home.layouts.app')

@push('styles')
    @vite('resources/css/informasi-publik.css')
@endpush

@section('contents')
    @php
        /*
        |--------------------------------------------------------------------------
        | Presentation-only derived data
        |--------------------------------------------------------------------------
        | Relasi "ppids" sudah eager loaded oleh controller.
        | Operasi ini tidak membuat query database tambahan.
        */

        $dokumenCollection = $kategoriPpids->flatMap(fn($kategori) => $kategori->ppids);

        $years = $dokumenCollection->pluck('tahun')->filter()->unique()->sortDesc()->values();

        $jumlahKategori = $totalKategori ?? $kategoriPpids->count();
        $tahunTerbaru = $lastUpdate ?? $years->first();
    @endphp

    <div class="ip-page" id="informasi-publik">

        {{-- ============================================================
        HERO
        ============================================================= --}}
        <section class="ip-hero" aria-labelledby="ip-hero-title">
            <div class="ip-hero-pattern" aria-hidden="true"></div>
            <div class="ip-orb ip-orb-one" aria-hidden="true"></div>
            <div class="ip-orb ip-orb-two" aria-hidden="true"></div>

            <div class="container">

                {{-- Breadcrumb --}}
                <nav class="ip-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>

                    <i class="fa-solid fa-chevron-right ip-breadcrumb-separator" aria-hidden="true"></i>

                    <span aria-current="page">Informasi Publik</span>
                </nav>

                <div class="ip-hero-grid">

                    {{-- Hero copy --}}
                    <div class="ip-hero-copy">
                        <div class="ip-hero-eyebrow">
                            <span class="ip-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-solid fa-landmark"></i>
                            </span>
                            <span>PPID DISPUSAKA</span>
                        </div>

                        <h1 id="ip-hero-title">
                            Informasi publik.
                            <span>Mudah ditemukan.</span>
                        </h1>

                        <p class="ip-hero-description">
                            Akses dokumen resmi DISPUSAKA Provinsi Sulawesi Tengah
                            secara cepat, terstruktur, dan transparan melalui pusat
                            informasi publik digital.
                        </p>

                        <div class="ip-hero-points" aria-label="Keunggulan layanan informasi publik">
                            <span>
                                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                Dokumen resmi
                            </span>

                            <span>
                                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                Terstruktur per kategori
                            </span>

                            <span>
                                <i class="fa-solid fa-unlock-keyhole" aria-hidden="true"></i>
                                Akses terbuka
                            </span>
                        </div>
                    </div>

                    {{-- Decorative / informational visual --}}
                    <div class="ip-hero-visual" aria-hidden="true">
                        <div class="ip-visual-ring ip-visual-ring-one"></div>
                        <div class="ip-visual-ring ip-visual-ring-two"></div>

                        <div class="ip-visual-card">
                            <div class="ip-visual-card-head">
                                <span class="ip-visual-status">
                                    <span></span>
                                    PPID DISPUSAKA
                                </span>

                                <i class="fa-regular fa-folder-open"></i>
                            </div>

                            <div class="ip-visual-document">
                                <span class="ip-visual-icon">
                                    <i class="fa-solid fa-file-shield"></i>
                                </span>

                                <div>
                                    <small>Akses Informasi Publik</small>
                                    <strong>
                                        Dokumen resmi dalam satu pusat informasi.
                                    </strong>
                                </div>
                            </div>

                            <div class="ip-visual-lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="ip-visual-footer">
                                <span>{{ number_format($totalDokumen) }}</span>
                                <small>dokumen tersedia</small>
                            </div>
                        </div>

                        <div class="ip-floating-card ip-floating-card-one">
                            <i class="fa-solid fa-layer-group"></i>
                            <div>
                                <small>Terstruktur</small>
                                <strong>Per kategori informasi</strong>
                            </div>
                        </div>

                        <div class="ip-floating-card ip-floating-card-two">
                            <i class="fa-brands fa-google-drive"></i>
                            <div>
                                <small>Akses dokumen</small>
                                <strong>Google Drive</strong>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ============================================================
        STATISTICS
        ============================================================= --}}
        <section class="ip-stat-section" aria-label="Ringkasan informasi publik">
            <div class="container">
                <div class="ip-stat-shell">

                    <div class="ip-stat-item">
                        <span class="ip-stat-icon" aria-hidden="true">
                            <i class="fa-regular fa-file-lines"></i>
                        </span>

                        <div>
                            <strong>{{ number_format($totalDokumen) }}</strong>
                            <span>Dokumen Publik</span>
                        </div>
                    </div>

                    <div class="ip-stat-divider" aria-hidden="true"></div>

                    <div class="ip-stat-item">
                        <span class="ip-stat-icon" aria-hidden="true">
                            <i class="fa-solid fa-folder-tree"></i>
                        </span>

                        <div>
                            <strong>{{ number_format($jumlahKategori) }}</strong>
                            <span>Kategori Informasi</span>
                        </div>
                    </div>

                    <div class="ip-stat-divider" aria-hidden="true"></div>

                    <div class="ip-stat-item">
                        <span class="ip-stat-icon" aria-hidden="true">
                            <i class="fa-regular fa-calendar-check"></i>
                        </span>

                        <div>
                            <strong>{{ $tahunTerbaru ?: '—' }}</strong>
                            <span>Tahun Dokumen Terbaru</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ============================================================
        DOCUMENT DIRECTORY
        ============================================================= --}}
        <section class="ip-content-section" aria-labelledby="ip-document-heading">
            <div class="container">

                <div class="ip-section-heading">
                    <div>
                        <span class="ip-section-eyebrow">
                            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                            PPID DISPUSAKA
                        </span>

                        <h2 id="ip-document-heading">
                            Dokumen Informasi Publik
                        </h2>

                        <p>
                            Cari dokumen berdasarkan nama atau pilih tahun publikasi.
                            Dokumen dikelompokkan sesuai kategori informasi.
                        </p>
                    </div>

                    <div class="ip-section-status">
                        <span class="ip-status-dot" aria-hidden="true"></span>
                        <div>
                            <small>Status</small>
                            <strong>Informasi dapat diakses publik</strong>
                        </div>
                    </div>
                </div>

                {{-- Search / filter --}}
                <form class="ip-filter-panel" id="ipFilterForm" role="search" aria-label="Cari dokumen informasi publik">
                    <div class="ip-search-control">
                        <label for="ipSearch">
                            Cari dokumen
                        </label>

                        <div class="ip-search-input">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>

                            <input type="search" id="ipSearch" name="q"
                                placeholder="Contoh: laporan kinerja, renstra, SOP..." autocomplete="off"
                                enterkeyhint="search">

                            <button type="button" class="ip-input-clear" id="ipInputClear"
                                aria-label="Hapus kata pencarian" hidden>
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="ip-year-control">
                        <label for="ipYearFilter">
                            Tahun
                        </label>

                        <div class="ip-select-wrap">
                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>

                            <select id="ipYearFilter" name="tahun">
                                <option value="">Semua tahun</option>

                                @foreach ($years as $year)
                                    <option value="{{ $year }}">
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>

                            <i class="fa-solid fa-chevron-down ip-select-chevron" aria-hidden="true"></i>
                        </div>
                    </div>
                </form>

                {{-- Result controls --}}
                <div class="ip-result-toolbar">
                    <p class="ip-result-status" id="ipResultStatus" role="status" aria-live="polite"
                        aria-atomic="true">
                        <strong id="ipResultCount">
                            {{ number_format($totalDokumen) }}
                        </strong>
                        dokumen ditemukan
                    </p>

                    <div class="ip-result-actions">
                        <button type="button" class="ip-toolbar-button ip-reset-button" id="ipResetFilters" disabled>
                            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                            Reset filter
                        </button>

                        <button type="button" class="ip-toolbar-button ip-expand-button" id="ipToggleAll"
                            aria-expanded="true">
                            <i class="fa-solid fa-angles-up" aria-hidden="true"></i>
                            <span>Tutup semua</span>
                        </button>
                    </div>
                </div>

                {{-- Global no result --}}
                <div class="ip-no-results" id="ipNoResults" hidden>
                    <span class="ip-no-results-icon" aria-hidden="true">
                        <i class="fa-regular fa-folder-open"></i>
                    </span>

                    <span class="ip-no-results-eyebrow">
                        Tidak ada hasil
                    </span>

                    <h3>Dokumen tidak ditemukan</h3>

                    <p>
                        Coba gunakan kata pencarian yang lebih singkat atau pilih
                        tahun yang berbeda.
                    </p>

                    <button type="button" id="ipNoResultsReset">
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                        Tampilkan semua dokumen
                    </button>
                </div>

                {{-- Categories --}}
                <div class="ip-category-list" id="ipCategoryList" data-total-documents="{{ $totalDokumen }}">
                    @foreach ($kategoriPpids as $kategori)
                        @php
                            $categoryId = 'ip-category-' . $kategori->id;
                            $panelId = $categoryId . '-panel';
                            $headingId = $categoryId . '-heading';
                        @endphp

                        <section class="ip-category is-open" data-category-name="{{ mb_strtolower($kategori->nm_ppid) }}"
                            data-total-documents="{{ $kategori->ppids->count() }}">
                            <h3 class="ip-category-heading" id="{{ $headingId }}">
                                <button type="button" class="ip-category-toggle" aria-expanded="true"
                                    aria-controls="{{ $panelId }}">
                                    <span class="ip-category-heading-main">
                                        <span class="ip-category-icon" aria-hidden="true">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </span>

                                        <span class="ip-category-copy">
                                            <span class="ip-category-name">
                                                {{ $kategori->nm_ppid }}
                                            </span>

                                            <span class="ip-category-meta">
                                                <span class="ip-category-visible-count" data-category-count>
                                                    {{ $kategori->ppids->count() }}
                                                </span>
                                                dokumen
                                            </span>
                                        </span>
                                    </span>

                                    <span class="ip-category-chevron" aria-hidden="true">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </button>
                            </h3>

                            <div class="ip-category-panel" id="{{ $panelId }}"
                                aria-labelledby="{{ $headingId }}">
                                @if ($kategori->ppids->isNotEmpty())
                                    <div class="ip-table-shell">
                                        <table class="ip-table">
                                            <caption class="ip-sr-only">
                                                Daftar dokumen kategori
                                                {{ $kategori->nm_ppid }}
                                            </caption>

                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        Dokumen
                                                    </th>

                                                    <th scope="col" class="ip-year-heading">
                                                        Tahun
                                                    </th>

                                                    <th scope="col" class="ip-action-heading">
                                                        Akses
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($kategori->ppids as $doc)
                                                    @php
                                                        $link = $doc->file;

                                                        if (
                                                            is_string($link) &&
                                                            str_contains($link, 'drive.google.com')
                                                        ) {
                                                            $link = str_replace('/view', '/preview', $link);
                                                        }

                                                        $searchText = mb_strtolower(
                                                            trim($kategori->nm_ppid . ' ' . $doc->judul),
                                                        );
                                                    @endphp

                                                    <tr class="ip-document-row" data-document-row
                                                        data-search="{{ $searchText }}"
                                                        data-year="{{ $doc->tahun }}">
                                                        <th scope="row" data-label="Dokumen" class="ip-document-cell">
                                                            <div class="ip-document-info">
                                                                <span class="ip-document-icon" aria-hidden="true">
                                                                    <i class="fa-regular fa-file-lines"></i>
                                                                </span>

                                                                <span class="ip-document-copy">
                                                                    <span class="ip-document-title">
                                                                        {{ $doc->judul }}
                                                                    </span>

                                                                    <span class="ip-document-source">
                                                                        <i class="fa-brands fa-google-drive"
                                                                            aria-hidden="true"></i>
                                                                        Google Drive
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </th>

                                                        <td data-label="Tahun" class="ip-year-cell">
                                                            <span class="ip-year-badge">
                                                                {{ $doc->tahun ?: '—' }}
                                                            </span>
                                                        </td>

                                                        <td data-label="Akses" class="ip-action-cell">
                                                            <a href="{{ $link }}" target="_blank"
                                                                rel="noopener noreferrer" class="ip-document-action"
                                                                data-drive-link>
                                                                <span>Lihat dokumen</span>

                                                                <i class="fa-solid fa-arrow-up-right-from-square"
                                                                    aria-hidden="true"></i>

                                                                <span class="ip-sr-only">
                                                                    {{ $doc->judul }},
                                                                    dibuka di tab baru
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="ip-category-no-match" data-category-empty hidden>
                                            Tidak ada dokumen pada kategori ini
                                            yang sesuai dengan filter.
                                        </div>
                                    </div>
                                @else
                                    <div class="ip-category-empty">
                                        <span aria-hidden="true">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </span>

                                        <div>
                                            <strong>Belum ada dokumen</strong>
                                            <p>
                                                Dokumen untuk kategori ini belum
                                                tersedia untuk publik.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/informasi-publik.js')
@endpush
