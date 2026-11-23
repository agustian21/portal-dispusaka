@extends('administrator.layouts.app')
@section('title', 'Beranda')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Utama</span><span>/</span><span aria-current="page">Beranda</span>
            </nav>
            <h1>Beranda</h1>
            <p>Pantau publikasi, layanan PPID, dan kunjungan portal dari satu tampilan.</p>
        </div>
        <div class="head-actions">
            <button class="btn btn-secondary" type="button" onclick="window.location.reload()">
                <i class="fa-solid fa-rotate" aria-hidden="true"></i>Segarkan
            </button>
            <a class="btn btn-yellow" href="{{ route('panel.berita.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Buat berita
            </a>
        </div>
    </div>
    <section class="stats-grid" aria-label="Ringkasan statistik">
        <article class="stat-card" style="--tint:#101621;--tone:#155cc0">
            <div class="stat-top">
                <span class="stat-icon">
                    <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                </span>
                <span class="stat-trend">
                    @if ($trendBerita >= 0)
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        +{{ $trendBerita }}%
                    @else
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        {{ $trendBerita }}%
                    @endif
                </span>
            </div>
            <h3>{{ number_format($jumlahBerita) }}</h3>
            <p>Berita terbit</p>
        </article>
        <article class="stat-card" style="--tint:#e5f7ef;--tone:#159568">
            <div class="stat-top">
                <span class="stat-icon">
                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                </span>
                <span class="stat-trend">
                    @if ($trendVisitor >= 0)
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        +{{ $trendVisitor }}%
                    @else
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        {{ $trendVisitor }}%
                    @endif
                </span>
            </div>
            <h3>{{ number_format($jumlahVisitor) }}</h3>
            <p>Kunjungan bulan ini</p>
        </article>
        <article class="stat-card" style="--tint:#fff2b9;--tone:#b67800">
            <div class="stat-top">
                <span class="stat-icon">
                    <i class="fa-solid fa-video" aria-hidden="true"></i>
                </span>
                <span class="stat-trend">
                    @if ($trendVideo >= 0)
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        +{{ $trendVideo }}%
                    @else
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        {{ $trendVideo }}%
                    @endif
                </span>
            </div>
            <h3>{{ number_format($jumlahVideo) }}</h3>
            <p>Video kegiatan</p>
        </article>
        <article class="stat-card" style="--tint:#f0e9ff;--tone:#7751c9">
            <div class="stat-top">
                <span class="stat-icon">
                    <i class="fa-solid fa-file-shield" aria-hidden="true"></i>
                </span>
                <span class="stat-trend">
                    @if ($trendPpid >= 0)
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        +{{ $trendPpid }}%
                    @else
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        {{ $trendPpid }}%
                    @endif
                </span>
            </div>
            <h3>{{ number_format($jumlahPpid) }}</h3>
            <p>Dokumen PPID</p>
        </article>
    </section>
    <section class="dashboard-grid">
        <article class="card">
            <div class="card-head">
                <div>
                    <h2>Kunjungan Website</h2>
                    <p>Periode {{ $bulan[0] }} sampai {{ $bulan[count($bulan) - 1] }}</p>
                </div>
                <div class="chart-legend">
                    <span>
                        <span class="legend-dot"></span>Kunjungan
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap" data-visitor-chart></div>
            </div>
        </article>

        <article class="card">
            <div class="card-head">
                <div>
                    <h2>Aktivitas Terbaru</h2>
                    <p>Pembaruan konten oleh tim</p>
                </div><a href="berita.html" style="color:#155cc0;font-size:10px;font-weight:600">Lihat
                    semua</a>
            </div>
            <div class="card-body activity-list">
                @foreach ($aktivitas as $item)
                    <div class="activity">
                        <span class="activity-icon">
                            <i class="fa-solid {{ $item['icon'] }}"></i>
                        </span>
                        <span>
                            <strong>
                                {{ $item['judul'] }}
                            </strong>
                            <small>
                                {{ $item['user'] ?? 'Administrator' }},
                                {{ $item['waktu'] }}
                            </small>
                        </span>
                    </div>
                @endforeach
            </div>
        </article>
    </section>
    <div class="info-banner">
        <span class="info-icon"><i class="fa-solid fa-building-columns" aria-hidden="true"></i></span>
        <span><strong>Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah</strong>
            <span>
                Jln. Banteng No. 6 Palu · Email : dispusarda@sultengprov.go.id dan sultengperpus@gmail.com
            </span>
        </span>
    </div>
    <script>
        window.visitorData = @json($jumlahKunjungan);

        window.visitorLabels = @json($bulan);


        console.log(
            "Visitor Data:",
            window.visitorData
        );
    </script>
@endsection