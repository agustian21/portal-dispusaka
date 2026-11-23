@extends('administrator.layouts.app')
@section('title', 'User dan Role')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Administrasi</span><span>/</span>
                <span aria-current="page">User dan Role</span>
            </nav>
            <h1>User dan Role</h1>
            <p>Kelola akun pengguna dan hak akses yang diberikan oleh Superadmin.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-primary" href="{{ route('panel.users.create') }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah User
            </a>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box"><span class="sr-only">Cari data User dan Role</span>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="search" data-table-search placeholder="Cari data...">
                </label>
            </div>
            <div class="table-tools-right">
                <label class="rows-select">Tampilkan
                    <select data-table-rows>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>
                    baris
                </label>
            </div>
        </div>
        <div class="table-scroll">
            <table class="data-table" data-table>
                <caption class="sr-only">User dan Role</caption>
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th data-sort="text">Nama</th>
                        <th data-sort="text">Email</th>
                        <th data-sort="text">Hak Akses</th>
                        <th data-sort="text">Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td data-sort-value="{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                            <td>
                                <div class="cell-title">{{ $user->name }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-role badge-role-editor">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td><span class="badge badge-active" data-status-badge>Aktif</span></td>
                            <td>
                                <div class="action-group">
                                    <a class="action-btn" href="{{ route('panel.users.edit', $user->id) }}"
                                        aria-label="Edit data" title="Edit">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </a>
                                    <form action="{{ route('panel.users.destroy', $user->id) }}" method="POST"
                                        class="delete-form" style="display:inline;">
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
            <span data-table-info>
                Menampilkan
                {{ $users->firstItem() ?? 0 }}
                –
                {{ $users->lastItem() ?? 0 }}
                dari
                {{ $users->total() }}
                data
            </span>
            <nav class="pagination" data-table-pagination aria-label="Navigasi halaman tabel">
                {{ $users->links() }}
            </nav>
        </div>
    </section>
@endsection
