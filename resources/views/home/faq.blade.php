@extends('home.layouts.app')

@section('title', 'FAQ Layanan | DISPUSAKA Provinsi Sulawesi Tengah')

@section(
    'meta_description',
    'Temukan jawaban atas pertanyaan yang sering diajukan mengenai layanan Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah.'
)

@push('styles')
    @vite('resources/css/faq.css')
@endpush

@section('contents')
    <div class="faq-page" data-faq-page>

        {{-- ===HERO=== --}}
        <section class="faq-hero">
            <div class="faq-hero-pattern" aria-hidden="true"></div>
            <div class="faq-orb faq-orb-one" aria-hidden="true"></div>
            <div class="faq-orb faq-orb-two" aria-hidden="true"></div>

            <div class="container">

                {{-- Breadcrumb --}}
                <nav class="faq-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('beranda') }}">
                        <i class="fa-solid fa-house" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>
                    <i class="fa-solid fa-chevron-right faq-breadcrumb-separator" aria-hidden="true"></i>
                    <span aria-current="page">FAQ</span>
                </nav>
                <div class="faq-hero-grid">

                    {{-- Hero copy --}}
                    <div class="faq-hero-copy">
                        <div class="faq-hero-eyebrow">
                            <span class="faq-hero-eyebrow-icon" aria-hidden="true">
                                <i class="fa-regular fa-circle-question"></i>
                            </span>
                            <span>Pusat Bantuan DISPUSAKA</span>
                        </div>
                        <h1>Cari jawaban.<span>Tanpa berputar-putar.</span></h1>
                        <p class="faq-hero-description">
                            Temukan informasi layanan perpustakaan dan kearsipan melalui jawaban yang ringkas, jelas, dan
                            mudah dicari.
                        </p>

                        <div class="faq-hero-points" aria-label="Fitur FAQ">
                            <span>
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                Pencarian instan
                            </span>
                            <span>
                                <i class="fa-regular fa-keyboard" aria-hidden="true"></i>
                                Ramah keyboard
                            </span>
                            <span>
                                <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i>
                                Nyaman di mobile
                            </span>
                        </div>
                    </div>

                    {{-- Hero visual --}}
                    <div class="faq-hero-visual" aria-hidden="true">

                        <div class="faq-visual-ring faq-visual-ring-one"></div>
                        <div class="faq-visual-ring faq-visual-ring-two"></div>
                        <div class="faq-visual-card">
                            <div class="faq-visual-card-head">
                                <span class="faq-visual-status"><span></span>Pusat Informasi</span>
                                <i class="fa-regular fa-circle-question"></i>
                            </div>

                            <div class="faq-visual-question">
                                <span class="faq-visual-icon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <div>
                                    <small>Punya pertanyaan?</small>
                                    <strong>Cari jawabannya dalam hitungan detik.</strong>
                                </div>
                            </div>

                            <div class="faq-visual-lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="faq-visual-footer">
                                <span>{{ $faqs->count() }}</span>
                                <small>jawaban tersedia</small>
                            </div>
                        </div>

                        <div class="faq-floating-card faq-floating-card-one">
                            <i class="fa-solid fa-bolt"></i>
                            <div>
                                <small>Akses cepat</small>
                                <strong>Tanpa reload</strong>
                            </div>
                        </div>

                        <div class="faq-floating-card faq-floating-card-two">
                            <i class="fa-solid fa-universal-access"></i>
                            <div>
                                <small>Accessible</small>
                                <strong>Keyboard ready</strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================
        FAQ CONTENT
        ======================================================= --}}
        <section class="faq-content-section">
            <div class="container">

                <div class="faq-section-heading">

                    <div>
                        <div class="faq-section-eyebrow">
                            <i class="fa-solid fa-sparkles" aria-hidden="true"></i>Pertanyaan & Jawaban
                        </div>
                        <h2>Informasi yang sering ditanyakan</h2>
                        <p>
                            Pilih pertanyaan untuk melihat jawaban. Anda dapat membuka beberapa jawaban sekaligus untuk
                            membandingkan informasi.
                        </p>
                    </div>

                    <div class="faq-heading-actions">
                        <span class="faq-result-count" id="faqResultCount" data-faq-result-count aria-live="polite"
                            aria-atomic="true">
                            {{ $faqs->count() }} pertanyaan tersedia
                        </span>

                        @if ($faqs->isNotEmpty())
                            <button class="faq-expand-all" type="button" data-faq-expand-all>
                                <i class="fa-solid fa-angles-down" aria-hidden="true" data-faq-expand-icon></i>
                                <span data-faq-expand-label>Buka semua</span>
                            </button>
                        @endif

                    </div>
                </div>

                <div class="faq-layout">

                    {{-- ===============================
                    FAQ LIST
                    ================================ --}}
                    <div class="faq-list-column full-width">
                        <div class="faq-list" id="faqList" data-faq-list>
                            @forelse ($faqs as $faq)
                                @php
    $faqId = $faq->getKey();
                                @endphp

                                <article class="faq-item" id="faq-item-{{ $faqId }}" data-faq-item>
                                    <h3 class="faq-question-heading">
                                        <button class="faq-question" type="button" id="faq-trigger-{{ $faqId }}"
                                            aria-expanded="false" aria-controls="faq-panel-{{ $faqId }}" data-faq-trigger>
                                            <span class="faq-question-main">
                                                <span class="faq-number" aria-hidden="true">
                                                    {{ sprintf('%02d', $loop->iteration) }}
                                                </span>
                                                <span class="faq-question-text">
                                                    {{ $faq->judul }}
                                                </span>
                                            </span>
                                            <span class="faq-toggle" aria-hidden="true">
                                                <i class="fa-solid fa-plus"></i>
                                            </span>
                                        </button>
                                    </h3>

                                    <div class="faq-answer" id="faq-panel-{{ $faqId }}"
                                        aria-labelledby="faq-trigger-{{ $faqId }}" data-faq-panel hidden>
                                        <div class="faq-answer-inner">
                                            <div class="faq-answer-mark" aria-hidden="true">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <div class="faq-answer-content">
                                                <span class="faq-answer-label">Jawaban</span>
                                                <div class="faq-answer-text">
                                                    {!! nl2br(trim(html_entity_decode(strip_tags($faq->isi)))) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                            @empty
                                <div class="faq-server-empty">
                                    <div class="faq-server-empty-icon">
                                        <i class="fa-regular fa-circle-question"></i>
                                    </div>
                                    <span class="faq-empty-eyebrow">Belum ada informasi</span>
                                    <h2>FAQ sedang dipersiapkan</h2>
                                    <p>
                                        Informasi pertanyaan dan jawaban akanditampilkan di halaman ini setelah tersedia.
                                    </p>
                                    <a href="{{ route('beranda') }}">
                                        <i class="fa-solid fa-arrow-left"></i>Kembali ke Beranda
                                    </a>
                                </div>
                            @endforelse
                        </div>

                        {{-- No result dari client-side search --}}
                        <div class="faq-no-results" data-faq-no-results hidden>
                            <div class="faq-no-results-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <span>Tidak ada hasil</span>
                            <h3>Belum menemukan jawaban yang cocok</h3>
                            <p>
                                Coba gunakan kata kunci yang lebih singkat atau hapus pencarian untuk melihat seluruh FAQ.
                            </p>
                            <button type="button" data-faq-reset>
                                <i class="fa-solid fa-rotate-left"></i>Tampilkan semua FAQ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================
        BOTTOM CTA
        ======================================================= --}}
        <section class="faq-bottom-section">
            <div class="container">
                <div class="faq-bottom-card">
                    <div class="faq-bottom-decoration" aria-hidden="true"></div>
                    <div class="faq-bottom-icon" aria-hidden="true">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <div class="faq-bottom-copy">
                        <span>Jelajahi DISPUSAKA</span>
                        <h2>Informasi tidak berhenti di halaman FAQ.</h2>
                        <p>
                            Temukan layanan perpustakaan, kearsipan, berita kegiatan, koleksi audiovisual, dan informasi
                            publik lainnya.
                        </p>
                    </div>
                    <a class="faq-bottom-button" href="{{ route('beranda') }}#layanan">
                        Lihat layanan
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/faq.js')
@endpush
