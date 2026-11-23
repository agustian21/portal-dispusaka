@extends('administrator.layouts.app')
@section('title', 'Informasi Publik')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>PPID</span><span>/</span>
                <span aria-current="page">Informasi Publik</span>
            </nav>
            <h1>Informasi Publik</h1>
            <p>Kelola dokumen informasi publik dan tautan PDF.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-primary" href="{{ route('panel.ppid.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah Informasi Publik
            </a>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box">
                    <span class="sr-only">Cari data Informasi Publik</span>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="search" data-table-search placeholder="Cari data...">
                </label>
            </div>
            <div class="table-tools-right">
                <label class="rows-select">Tampilkan
                    <select data-table-rows>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    baris
                </label>
            </div>
        </div>
        <div class="table-scroll">
            <table class="data-table" data-table>
                <caption class="sr-only">Informasi Publik</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th data-sort="text">Judul</th>
                        <th data-sort="text">Kategori</th>
                        <th>Link PDF</th>
                        <th data-sort="number">Tahun</th>
                        <th data-sort="text">Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ppid as $item)
                        <tr>
                            <td data-sort-value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                            <td>
                                <div class="cell-title">{{ $item->judul }}
                                    <span class="cell-sub">{{ $item->katppid->nm_ppid ?? '-' }}</span>
                                </div>
                            </td>
                            <td>{{ $item->katinformasi->nama_katinformasi ?? '-' }}</td>
                            <td>
                                @if (!empty($item->file))
                                    <a href="{{ $item->file }}" target="_blank" rel="noopener noreferrer"
                                        style="color:#155cc0;font-weight:600">
                                        <i class="fa-brands fa-google-drive" aria-hidden="true"
                                            style="margin-right:6px"></i> Buka Dokumen
                                    </a>
                                @else
                                    <span style="color:#777;"> Tidak ada link </span>
                                @endif
                            </td>
                            <td data-sort-value="{{ $item->tahun }}"> {{ $item->tahun }}</td>
                            <td>
                                @if ($item->status_id == 1)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Non-aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.ppid.edit', $item->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn" href="{{ route('panel.ppid.status', $item->id) }}"
                                        aria-label="Ubah status" title="Ubah status">
                                        <i class="fa-solid {{ $item->status_id == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"
                                            aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('panel.ppid.destroy', $item->id) }}" method="POST"
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
        <div class="empty-state" data-table-empty>
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <strong>Data tidak ditemukan</strong>
            <p>Coba gunakan kata kunci yang berbeda.</p>
        </div>
        <div class="table-footer">
            <span data-table-info></span>
            <nav class="pagination" data-table-pagination aria-label="Navigasi halaman tabel"></nav>
        </div>
    </section>
@endsection
