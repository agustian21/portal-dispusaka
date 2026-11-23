@extends('administrator.layouts.app')
@section('title', 'Video')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Video</span>
            </nav>
            <h1>Video</h1>
            <p>Kelola video kegiatan dan tautan kanal publikasi.</p>
        </div>
        <div class="head-actions"><a class="btn btn-primary" href="{{ route('panel.video.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah Video</a>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box">
                    <span class="sr-only">Cari data Video</span>
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
                <caption class="sr-only">Video</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th data-sort="text">Judul</th>
                        <th>Link Video</th>
                        <th data-sort="date">Tanggal Upload</th>
                        <th data-sort="text">Status</th>
                        <th data-sort="text">Dibuat Oleh</th>
                        <th data-sort="text">Diubah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($video as $key => $item)
                        <tr>
                            <td data-sort-value="{{ $key + 1 }}">{{ $key + 1 }}</td>
                            <td>
                                <div class="cell-title">{{ $item->judul }}</div>
                            </td>
                            <td><a href="{{ $item->linkvideo }}" target="_blank" rel="noopener"
                                    style="color:#155cc0;font-weight:600"><i class="fa-solid fa-arrow-up-right-from-square"
                                        aria-hidden="true" style="margin-right:6px"></i>{{ $item->linkvideo }}</a>
                            </td>
                            <td data-sort-value="{{ \Carbon\Carbon::parse($item->tglupload)->format('d-m-Y') }}">
                                {{ \Carbon\Carbon::parse($item->tglupload)->format('d-m-Y') }}
                            </td>
                            <td><span class="badge badge-active">{{ $item->status_id == 1 ? 'Aktif' : 'Non-Aktif' }}</span>
                            </td>
                            <td>{{ $item->created_by }}</td>
                            <td>{{ $item->updated_by }}</td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.video.edit', $item->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn" href="{{ route('panel.video.status', $item->id) }}"
                                        title="Ubah Status">
                                        @if ($item->status_id == 1)
                                            <i class="fa-solid fa-toggle-on"></i>
                                        @else
                                            <i class="fa-solid fa-toggle-off"></i>
                                        @endif
                                    </a>
                                    <form action="{{ route('panel.video.destroy', $item->id) }}" method="POST"
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
