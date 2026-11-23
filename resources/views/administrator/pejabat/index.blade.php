@extends('administrator.layouts.app')
@section('title', 'Profil Pejabat')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Profil Pejabat</span>
            </nav>
            <h1>Profil Pejabat</h1>
            <p>Kelola data pejabat, jabatan, pangkat, dan informasi kepegawaian.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-primary" href="{{ route('panel.data-pejabat.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah Profil Pejabat
            </a>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box"><span class="sr-only">Cari data Profil Pejabat</span>
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
                    </select>baris
                </label>
            </div>
        </div>
        <div class="table-scroll">
            <table class="data-table" data-table>
                <caption class="sr-only">Profil Pejabat</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th>Foto</th>
                        <th data-sort="text">Nama</th>
                        <th data-sort="text">NIP</th>
                        <th data-sort="text">Pangkat/Golongan</th>
                        <th data-sort="text">Jabatan</th>
                        <th data-sort="text">Bidang</th>
                        <th data-sort="text">Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pejabat as $item)
                        <tr>
                            <td data-sort-value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                            <td>
                                @php
                                    $fotoUrl = null;

                                    if (!empty($item->foto)) {
                                        // Normalisasi path dari database
                                        $fotoDatabase = str_replace('\\', '/', trim($item->foto));

                                        // Ambil nama file saja
                                        $fotoNama = basename($fotoDatabase);

                                        // Lokasi fisik file
                                        $fotoPath = public_path('uploads_files/pejabat/' . $fotoNama);

                                        // Pastikan file benar-benar ada
                                        if (is_file($fotoPath)) {
                                            $fotoUrl = asset('uploads_files/pejabat/' . rawurlencode($fotoNama));
                                        }
                                    }
                                @endphp

                                @if ($fotoUrl)
                                    <img src="{{ $fotoUrl }}" alt="Foto {{ $item->nama }}" loading="lazy"
                                        decoding="async"
                                        style="width: 48px; height: 58px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <span class="thumb-placeholder">
                                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-title">{{ $item->nama }}</div>
                            </td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->{'pangkat/gol'} }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->namabidang?->nama_bidang ?? '-' }}</td>
                            <td>
                                @if ($item->status_id == 1)
                                    <span class="badge badge-active">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge badge-draft">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.data-pejabat.edit', $item->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn" href="{{ route('panel.datapejabat.status', $item->id) }}"
                                        aria-label="{{ $item->status_id == 1 ? 'Nonaktifkan data pejabat' : 'Aktifkan data pejabat' }}"
                                        title="{{ $item->status_id == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fa-solid {{ $item->status_id == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }}"
                                            aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('panel.data-pejabat.destroy', $item->id) }}" method="POST"
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
        <div class="table-footer"><span data-table-info></span>
            <nav class="pagination" data-table-pagination aria-label="Navigasi halaman tabel"></nav>
        </div>
    </section>
@endsection
