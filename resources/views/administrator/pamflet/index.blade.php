@extends('administrator.layouts.app')

@section('title', 'Pengumuman dan Pamflet')

@section('contents')

    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Pengumuman dan Pamflet</span>
            </nav>
            <h1>Pengumuman dan Pamflet</h1>
            <p>Kelola pengumuman layanan, agenda, dan pamflet publik.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-primary" href="{{ route('panel.pamflet.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>Tambah Pengumuman dan Pamflet
            </a>
        </div>
    </div>

    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box">
                    <span class="sr-only">Cari data Pengumuman dan Pamflet</span>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="search" data-table-search placeholder="Cari data...">
                </label>
            </div>
            <div class="table-tools-right">
                <label class="rows-select">
                    Tampilkan
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
                <caption class="sr-only">Pengumuman dan Pamflet</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th>Gambar</th>
                        <th data-sort="text">Judul</th>
                        <th data-sort="date">Tanggal</th>
                        <th data-sort="text">Status</th>
                        <th data-sort="text">Dibuat Oleh</th>
                        <th data-sort="text">Diubah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pamflets as $pamflet)
                        @php
                            $gambarList = is_array($pamflet->gambar) ? $pamflet->gambar : [];
                            $gambarPertama = $gambarList[0] ?? null;
                            $jumlahGambar = count($gambarList);
                            $gambarTambahan = $jumlahGambar > 1 ? $jumlahGambar - 1 : 0;
                        @endphp
                        <tr>
                            <td data-sort-value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                            <td>
                                @if ($gambarPertama)
                                    <div style="position: relative; width: 70px;height: 55px;">

                                        <img src="{{ asset('uploads_files/pamflet/' . $gambarPertama) }}"
                                            alt="{{ $pamflet->nm_pamflet }}" loading="lazy"
                                            style="width: 70px; height: 55px; object-fit: cover; border-radius: 6px;display: block;">

                                        @if ($gambarTambahan > 0)
                                            <span title="{{ $jumlahGambar }} gambar"
                                                style="
                                                    position: absolute;
                                                    right: 4px;
                                                    bottom: 4px;
                                                    min-width: 24px;
                                                    padding: 2px 6px;
                                                    border-radius: 12px;
                                                    background: rgba(0, 0, 0, 0.72);
                                                    color: #ffffff;
                                                    font-size: 10px;
                                                    font-weight: 600;
                                                    line-height: 16px;
                                                    text-align: center;
                                                ">
                                                +{{ $gambarTambahan }}
                                            </span>
                                        @endif

                                    </div>
                                @else
                                    <span class="thumb-placeholder">
                                        <i class="fa-regular fa-image" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </td>
                            <td data-sort-value="{{ strtolower($pamflet->nm_pamflet) }}">
                                <div class="cell-title">{{ $pamflet->nm_pamflet }}</div>
                            </td>
                            <td data-sort-value="{{ optional($pamflet->created_at)->format('Y-m-d H:i:s') ?? '' }}">
                                {{ optional($pamflet->created_at)->format('d-m-Y') ?? '-' }}
                            </td>
                            <td data-sort-value="{{ $pamflet->status_id == 1 ? 'aktif' : 'non-aktif' }}">
                                @if ($pamflet->status_id == 1)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $pamflet->created_by ?? '-' }}</td>
                            <td>{{ $pamflet->updated_by ?? '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.pamflet.edit', $pamflet->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn" href="{{ route('panel.pamflet.status', $pamflet->id) }}"
                                        aria-label="{{ $pamflet->status_id == 1 ? 'Nonaktifkan pamflet' : 'Aktifkan pamflet' }}"
                                        title="{{ $pamflet->status_id == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fa-solid {{ $pamflet->status_id == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"
                                            aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('panel.pamflet.destroy', $pamflet->id) }}" method="POST"
                                        style="display: inline;">
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
                    @empty
                        {{-- Kosong. Empty state utama ditangani oleh JavaScript table. --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Empty State --}}
        <div class="empty-state" data-table-empty>
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <strong>Data tidak ditemukan</strong>
            <p>Coba gunakan kata kunci yang berbeda.</p>
        </div>

        {{-- Footer --}}
        <div class="table-footer">
            <span data-table-info></span>
            <nav class="pagination" data-table-pagination aria-label="Navigasi halaman tabel"></nav>
        </div>
    </section>
@endsection
