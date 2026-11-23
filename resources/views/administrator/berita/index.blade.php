@extends('administrator.layouts.app')
@section('title', 'Berita')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="index.html">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Berita</span>
            </nav>
            <h1>Berita</h1>
            <p>Kelola publikasi berita, status tayang, dan jumlah pembaca portal.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary"
                href="{{ route('panel.berita.export-pdf', request()->only(['search', 'tanggal_mulai', 'tanggal_akhir'])) }}">

                <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                Ekspor PDF
            </a>
            <a class="btn btn-primary" href="{{ route('panel.berita.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah berita
            </a>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>

        <form method="GET" action="{{ url()->current() }}" class="table-toolbar berita-filter">
            <div class="berita-filter-main">
                {{-- Search --}}
                <label class="search-box berita-search">
                    <span class="sr-only">Cari data berita</span>

                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>

                    <input type="search" name="search" value="{{ $search }}"
                        placeholder="Cari judul, pembuat, pengubah..." autocomplete="off">
                </label>

                {{-- Date Range --}}
                <div class="date-range-filter">
                    <span class="date-range-icon"><i class="fa-regular fa-calendar"></i></span>
                    <div class="date-field">
                        <span class="date-label">Dari</span>
                        <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}" aria-label="Tanggal mulai">
                    </div>
                    <span class="date-range-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    <div class="date-field">
                        <span class="date-label">Sampai</span>
                        <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" aria-label="Tanggal akhir">
                    </div>
                </div>

                {{-- Filter --}}
                <button type="submit" class="filter-submit">
                    <i class="fa-solid fa-filter"></i><span>Filter</span>
                </button>

                {{-- Reset --}}
                @if ($search || $tanggalMulai || $tanggalAkhir)
                    <a href="{{ route('panel.berita.index') }}" class="filter-reset" title="Reset filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

            <div class="table-tools-right">
                <label class="rows-select">
                    Tampilkan
                    <select name="rows" onchange="this.form.submit()">
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    baris
                </label>
            </div>

        </form>

        <div class="table-scroll">
            <table class="data-table">
                <caption class="sr-only">Daftar berita Portal Dispusarda Sulteng</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th data-sort="text">Judul</th>
                        <th>Gambar</th>
                        <th data-sort="text">Status</th>
                        <th data-sort="number">Pembaca</th>
                        <th data-sort="text">Dibuat Oleh</th>
                        <th data-sort="text">Diubah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berita as $item)
                        <tr>
                            <td>
                                {{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="cell-title">{{ $item->judul }}
                                    <span class="cell-sub">{{ optional($item->tgl)->format('d-m-Y') ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $gambarNama = null;
                                    $gambarUrl = null;

                                    if (!empty($item->gambar)) {
                                        // Normalisasi slash Windows/Linux
                                        $gambarDatabase = str_replace('\\', '/', $item->gambar);

                                        // Ambil nama file saja walaupun database menyimpan path
                                        $gambarNama = basename($gambarDatabase);

                                        // Lokasi fisik gambar
                                        $gambarPath = public_path('uploads_files/berita/' . $gambarNama);

                                        // Pastikan file benar-benar ada
                                        if (is_file($gambarPath)) {
                                            $gambarUrl = asset('uploads_files/berita/' . rawurlencode($gambarNama));
                                        }
                                    }
                                @endphp

                                @if ($gambarUrl)
                                    <img src="{{ $gambarUrl }}" alt="Foto {{ $item->judul }}" loading="lazy"
                                        decoding="async"
                                        style="width: 48px; height: 58px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <span class="thumb-placeholder">
                                        <i class="fa-regular fa-image" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_id == 1)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Non-Aktif</span>
                                @endif
                            </td>
                            <td data-sort-value="{{ $item->dibaca }}">
                                <i class="fa-regular fa-eye" aria-hidden="true" style="color:#7d8ca2;margin-right:6px"></i>
                                {{ number_format($item->dibaca ?? 0, 0, ',', '.') }}
                            </td>
                            <td>{{ $item->created_by ?? '-' }}</td>
                            <td>{{ $item->updated_by ?? '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.berita.edit', $item->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn" href="{{ route('panel.berita.status', $item->id) }}"
                                        aria-label="{{ $item->status_id == 1 ? 'Nonaktifkan berita' : 'Aktifkan berita' }}"
                                        title="{{ $item->status_id == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fa-solid {{ $item->status_id == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"
                                            aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('panel.berita.destroy', $item->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn delete" type="submit" data-berita-delete
                                            aria-label="Hapus data" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($berita->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <strong>Data tidak ditemukan</strong>
                <p>Coba gunakan kata kunci yang berbeda.</p>
            </div>
        @endif

        <div class="table-footer">
            <div>
                Menampilkan maksimal {{ $berita->perPage() }} data
            </div>

            <div class="pagination pagination-cursor">

                @if ($berita->previousPageUrl())
                    <a href="{{ $berita->previousPageUrl() }}" class="cursor-page-btn" aria-label="Halaman sebelumnya">
                        <span class="cursor-page-icon">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>

                        <span class="cursor-page-copy">
                            <small>Navigasi</small>
                            <strong>Sebelumnya</strong>
                        </span>
                    </a>
                @else
                    <span class="cursor-page-btn is-disabled">
                        <span class="cursor-page-icon">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>

                        <span class="cursor-page-copy">
                            <small>Navigasi</small>
                            <strong>Sebelumnya</strong>
                        </span>
                    </span>
                @endif


                @if ($berita->nextPageUrl())
                    <a href="{{ $berita->nextPageUrl() }}" class="cursor-page-btn cursor-page-next"
                        aria-label="Halaman berikutnya">
                        <span class="cursor-page-copy">
                            <small>Navigasi</small>
                            <strong>Berikutnya</strong>
                        </span>

                        <span class="cursor-page-icon">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    </a>
                @else
                    <span class="cursor-page-btn cursor-page-next is-disabled">
                        <span class="cursor-page-copy">
                            <small>Navigasi</small>
                            <strong>Berikutnya</strong>
                        </span>

                        <span class="cursor-page-icon">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    </span>
                @endif

            </div>
        </div>
    </section>

@endsection
