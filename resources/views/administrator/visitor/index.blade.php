@extends('administrator.layouts.app')

@section('title', 'Buku Tamu')

@section('contents')

    <div class="page-head">

        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Pengaturan</span><span>/</span>
                <span aria-current="page">Buku Tamu</span>
            </nav>
            <h1>Buku Tamu</h1>
            <p>Pantau kunjungan, tujuan, dan status tindak lanjut tamu.</p>
        </div>

        <div class="head-actions">
            <button class="btn btn-secondary" type="button" data-export-pdf>
                <i class="fa-solid fa-file-pdf" aria-hidden="true">
                </i>Ekspor PDF
            </button>
        </div>
    </div>


    <section class="card table-card">
        <form method="GET" action="{{ url()->current() }}" class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box">
                    <span class="sr-only">Cari data Buku Tamu</span>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari IP, negara, kota..."
                        autocomplete="off">
                </label>
            </div>

            <div class="table-tools-right">
                <label class="rows-select">
                    Tampilkan
                    <select name="rows" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
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
                <caption class="sr-only">Buku Tamu</caption>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>IP Publik</th>
                        <th>Tanggal</th>
                        <th>Negara</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>Lat</th>
                        <th>Long</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($visitor as $item)
                        <tr>
                            <td>
                                {{ ($visitor->currentPage() - 1) * $visitor->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="cell-title">
                                    {{ $item->ip }}
                                </div>
                            </td>
                            <td>
                                {{ $item->date }}
                            </td>
                            <td>
                                {{ $item->country }}
                            </td>
                            <td>
                                {{ $item->city }}
                            </td>
                            <td>
                                {{ $item->state_name }}
                            </td>
                            <td>
                                {{ $item->lat }}
                            </td>
                            <td>
                                {{ $item->long }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;">
                                <strong>Data tidak ditemukan</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- PAGINATION --}}
        <div class="table-footer">
            <span data-table-info>Menampilkan {{ $visitor->count() }} data</span>
            <div class="pagination pagination-cursor">

                @if ($visitor->previousPageUrl())
                    <a href="{{ $visitor->previousPageUrl() }}" class="cursor-page-btn" aria-label="Halaman sebelumnya">
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


                @if ($visitor->nextPageUrl())
                    <a href="{{ $visitor->nextPageUrl() }}" class="cursor-page-btn cursor-page-next"
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
    </section>

@endsection
