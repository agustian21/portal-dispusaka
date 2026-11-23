@extends('home.layouts.app')
@section('title', 'Koleksi Buku - DISPUSAKA Provinsi Sulawesi Tengah')

@push('styles')
    @vite('resources/css/koleksibuku.css')
@endpush

@section('contents')
    @php
        // Dummy data for demonstration (when database is not ready)
        $allBooks = [
            (object) [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => '1980',
                'kategori' => 'Fiksi & Literatura',
                'deskripsi' =>
                    'Karya monumental Pramoedya yang menggambarkan hidup kolonial di Jawa awal abad ke-20 melalui kisah cinta dan perjuangan Minke.',
                'cover_image' => 'bumi-manusia.jpg',
            ],
            (object) [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => '2005',
                'kategori' => 'Fiksi & Literatura',
                'deskripsi' =>
                    'Novel inspiratif tentang kemampuan seorang anak dari keluarga miskin untuk menggapai mimpi melalui pendidikan di sekolah dasar Negeri diBelitung.',
                'cover_image' => 'laskar-pelangi.jpg',
            ],
            (object) [
                'judul' => 'Sapiens: Sejarah Umum Manusia',
                'penulis' => 'Yuval Noah Harari',
                'tahun_terbit' => '2011',
                'kategori' => 'Ilmiah & Teknologi',
                'deskripsi' =>
                    'Jelajah pesat melalui sejarah umat manusia, dari zaman batu hingga era digital, mengeksplorasi apa yang membuat kita menjadi manusia.',
                'cover_image' => 'sapiens.jpg',
            ],
            (object) [
                'judul' => 'Pulang',
                'penulis' => 'Leila S. Chudori',
                'tahun_terbit' => '2012',
                'kategori' => 'Fiksi & Literatura',
                'deskripsi' =>
                    'Novel yang menyentuh tentang pengalaman exil dan pengembalian, terinspirasi dari peristiwa tragis 1965 dan dampaknya bagi keluarga nelayan.',
                'cover_image' => 'pulang.jpg',
            ],
            (object) [
                'judul' => 'Kerangka Filsafat Pancasila',
                'penulis' => 'Bagir Manan',
                'tahun_terbit' => '2023',
                'kategori' => 'Filsafat',
                'deskripsi' =>
                    'Analisis mendalam tentang filosofi dasar Pancasila sebagai fondasi negara Indonesia dalam konteks kontemporer.',
                'cover_image' => 'pancasila.jpg',
            ],
            (object) [
                'judul' => 'Inteligensi Emosional untuk Kepemimpinan',
                'penulis' => 'Daniel Goleman',
                'tahun_terbit' => '2022',
                'kategori' => 'Pengembangan Diri',
                'deskripsi' =>
                    'Panduan praktis untuk memanfaatkan inteligensi emosional dalam meningkatkan efektivitas kepemimpinan dan kerja tim.',
                'cover_image' => 'inteligensi-emosional.jpg',
            ],
            (object) [
                'judul' => 'Tanah Jawa dalam Era Digital',
                'penulis' => 'Bambang Hariyanto',
                'tahun_terbit' => '2023',
                'kategori' => 'Sejarah',
                'deskripsi' =>
                    'Studi tentang transformasi masyarakat Jawa dari tradisi ke era digital, mencakup aspek budaya, ekonomi, dan sosial.',
                'cover_image' => 'tanah-jawa-digital.jpg',
            ],
            (object) [
                'judul' => 'Memasak Sehat untuk Keluarga',
                'penulis' => 'Dr. Maya R.',
                'tahun_terbit' => '2022',
                'kategori' => 'Kesehatan',
                'deskripsi' =>
                    'Koleksi resep sehat, bergizi, dan mudah dibuat yang cocok untuk semua anggota keluarga dari anak hingga lansia.',
                'cover_image' => 'masak-sehat.jpg',
            ],
            (object) [
                'judul' => 'Bisnis Digital untuk Pemula',
                'penulis' => 'Budi Santoso',
                'tahun_terbit' => '2023',
                'kategori' => 'Bisnis & Ekonomi',
                'deskripsi' => 'Panduan praktis memulai dan mengembangkan bisnis online dalam時代 digital.',
                'cover_image' => 'bisnis-digital.jpg',
            ],
            (object) [
                'judul' => 'Agama dan Masyarakat Modern',
                'penulis' => 'Prof. Ahmad Yusuf',
                'tahun_terbit' => '2022',
                'kategori' => 'Agama & Filsafat',
                'deskripsi' => 'Analisis tentang peran agama dalam masyarakat kontemporer dan tantangan globalisasi.',
                'cover_image' => 'agama-modern.jpg',
            ],
            (object) [
                'judul' => 'Sejarah Kerajaan Sriwijaya',
                'penulis' => 'Dr. Rizal Sukma',
                'tahun_terbit' => '2021',
                'kategori' => 'Sejarah & Kebudayaan',
                'deskripsi' => 'Studi mendalam tentang salah satu kerajaan maritim terbesar dalam sejarah Indonesia.',
                'cover_image' => 'sriwijaya.jpg',
            ],
            (object) [
                'judul' => 'Pendidikan Karakter di Sekolah Dasar',
                'penulis' => 'Dra. Lestari Wijaya',
                'tahun_terbit' => '2023',
                'kategori' => 'Pendidikan & Pengembangan Diri',
                'deskripsi' =>
                    'Panduan untuk guru dan orang tua dalam menanamkan nilai-nilai positif pada anak sejak usia dini.',
                'cover_image' => 'pendidikan-karakter.jpg',
            ],
        ];
    @endphp

    <!-- Hero Section with Search -->
    <section class="hero-koleksi-buku">
        <div class="container">
            <div class="container">
                <h1>Koleksi Buku <span>DISPUSAKA</span></h1>
                <p>Jelajah ribuan judul buku dari berbagai kategori yang tersedia untuk membaca, penelitian, dan
                    pengembangan diri.</p>
            </div>

            <!-- Elevated Search Card -->
            <div class="container search-card">
                <div class="quick-search-wrap">
                    <form class="quick-search"
                        onsubmit="event.preventDefault(); alert('Demo pencarian: sambungkan field ini ke pencarian situs/backend Anda.');">
                        <div class="search-field">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input aria-label="Pencarian koleksi buku"
                                placeholder="Cari judul, penulis, atau kategori buku..." type="search" />
                        </div>
                        <button class="search-btn" type="submit">Cari Buku</button>
                    </form>
                </div>
            </div>

            <!-- Animated Background Elements -->
            <div class="floating-elements">
                <div class="floating-element floating-element-1"></div>
                <div class="floating-element floating-element-2"></div>
            </div>
        </div>
    </section>

    <!-- Books Section -->
    <section class="books-section">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Daftar Buku Tersedia</h2>
                    <p>Koleksi buku kami terus berkembang dengan judul baru yang relevan dan berkualitas.</p>
                </div>
                <div class="stats">
                    <span class="stat-item">@count($allBooks) Judul</span>
                    <span class="stat-item alt">{{ count(array_unique(array_column((array) $allBooks, 'kategori'))) }}
                        Kategori</span>
                </div>
            </div>

            @php
                // Pagination logic for dummy data
                $perPage = 12;
                $currentPage = 1; // In real implementation, this would come from request
                $totalItems = count($allBooks);
                $totalPages = (int) ceil($totalItems / $perPage);

                // Get current page items
                $offset = ($currentPage - 1) * $perPage;
                $paginatedBooks = array_slice($allBooks, $offset, $perPage, true);
            @endphp

            <!-- Books Grid -->
            <div class="books-grid">
                @foreach ($paginatedBooks as $book)
                    <article class="book-card"
                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">

                        <?php
                        // Ensure cover_image exists, otherwise use placeholder
                        $coverImage = isset($book->cover_image) && !empty($book->cover_image) ? 'uploads_files/buku/' . $book->cover_image : 'https://via.placeholder.com/280x350?f=pdf&amp;t=Book+Cover';
                        ?>

                        <!-- Book Cover -->
                        <div class="book-cover">
                            <img src="{{ asset($coverImage ?? 'https://via.placeholder.com/280x350?f=pdf&amp;t=Book+Cover') }}"
                                alt="{{ $book->judul }}">
                            <!-- Category Badge -->
                            <div class="category-badge">{{ $book->kategori }}</div>
                            <!-- New Badge (for demo) -->
                            @if ($book->tahun_terbit >= '2023')
                                <div class="new-badge">Baru</div>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="book-info">
                            <h3>{{ $book->judul }}</h3>
                            <div class="meta">
                                <span class="author">{{ $book->penulis }}</span>
                                <span class="year">{{ $book->tahun_terbit }}</span>
                            </div>
                            <p class="description">{{ Str::limit(strip_tags($book->deskripsi ?? $book->sinopsis), 150) }}
                            </p>
                            <div class="action-link">
                                <a href="#">
                                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination Controls -->
            @if ($totalPages > 1)
                <div class="pagination-section">
                    <div class="container">
                        <nav aria-label="Navigasi halaman buku">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="@if ($currentPage <= 1) disabled @endif">
                                    <a href="#"
                                        @if ($currentPage <= 1) style="pointer-events: none; opacity: 0.5;" @endif>
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                @php
                                    $showPages = 5; // Number of page links to show
                                    $startPage = max(1, $currentPage - floor($showPages / 2));
                                    $endPage = min($totalPages, $startPage + $showPages - 1);

                                    // Adjust start page if we're near the end
                                    if ($endPage - $startPage + 1 < $showPages) {
                                        $startPage = max(1, $endPage - $showPages + 1);
                                    }
                                @endphp

                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="@if ($i == $currentPage) active @endif">
                                        <a href="#"
                                            @if ($i == $currentPage) style="background: var(--gold); color: #17283c;" @else
                                                                     style="background: var(--surface-2); color: var(--muted);" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                <!-- Next Button -->
                                <li class="@if ($currentPage >= $totalPages) disabled @endif">
                                    <a href="#"
                                        @if ($currentPage >= $totalPages) style="pointer-events: none; opacity: 0.5;" @endif>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <p class="pagination-info">
                            Menampilkan {{ $offset + 1 }} - {{ min($offset + $perPage, $totalItems) }} dari
                            {{ $totalItems }} judul buku
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <div class="text-content">
                    <h2>Mulai Jelajahi Koleksi Sekarang!</h2>
                    <p>Akses koleksi buku kita kapan saja, di mana saja. Temukan pengetahuan, inspirasi, dan hiburan dalam
                        setiap halaman.</p>
                </div>
                <a href="#" class="btn-primary">Mulai Membaca</a>
            </div>
        </div>
    </section>
@endsection
