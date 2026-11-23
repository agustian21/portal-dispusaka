@extends('administrator.layouts.app')
@section('title', 'Nama Bidang')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Pengaturan</span><span>/</span>
                <span aria-current="page">Nama Bidang</span>
            </nav>
            <h1>Nama Bidang</h1>
            <p>Kelola referensi bidang untuk pengelompokan data.</p>
        </div>
        <div class="head-actions">
            <button class="btn btn-primary" type="button" data-modal-open="bidangModal" data-modal-mode="create"
                data-entity="Nama Bidang">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Tambah Nama Bidang
            </button>
        </div>
    </div>
    <section class="card table-card" data-table-wrapper>
        <div class="table-toolbar">
            <div class="table-tools-left">
                <label class="search-box"><span class="sr-only">Cari data</span>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="search" data-table-search placeholder="Cari nama bidang...">
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
                <thead>
                    <tr>
                        <th data-sort="number">No</th>
                        <th data-sort="text">Nama Bidang</th>
                        <th data-sort="text">Status</th>
                        <th data-sort="text">Dibuat Oleh</th>
                        <th data-sort="text">Diubah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($namabidangs as $key => $item)
                        <tr>
                            <td data-sort-value="{{ $key + 1 }}">{{ $key + 1 }}</td>
                            <td>
                                <div class="cell-title">{{ $item->nama_bidang }}
                                    <span class="cell-sub">{{ $item->deskripsi }}</span>
                                </div>
                            </td>
                            <td>
                                @if ($item->status_id == 1)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $item->created_by }}</td>
                            <td>{{ $item->updated_by }}</td>
                            <td>
                                <div class="action-group">
                                    <button class="action-btn" type="button" data-modal-open="bidangModal"
                                        data-modal-mode="edit" data-id="{{ $item->id }}"
                                        data-nama-bidang="{{ $item->nama_bidang }}" data-deskripsi="{{ $item->deskripsi }}"
                                        data-status-id="{{ $item->status_id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('panel.namabidang.destroy', $item->id) }}" method="POST"
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
        </div>
        <div class="table-footer">
            <span data-table-info></span>
            <nav class="pagination" data-table-pagination aria-label="Navigasi halaman tabel"></nav>
        </div>
    </section>

    <div class="modal" id="bidangModal" role="dialog" aria-modal="true" aria-labelledby="bidangModalTitle"
        aria-hidden="true">
        <div class="modal-backdrop"></div>
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h2 id="bidangModalTitle" data-modal-title>Tambah Nama Bidang</h2>
                    <p>Form modal khusus data referensi pengaturan.</p>
                </div>
                <button class="modal-close" type="button" data-modal-close aria-label="Tutup modal">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
            <form id="bidangForm" method="POST" action="{{ route('panel.namabidang.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="">
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="nama_bidang">Nama Bidang<span class="required">*</span></label>
                            <input class="form-control @error('nama_bidang') is-invalid @enderror" id="nama_bidang"
                                name="nama_bidang" required type="text" value="{{ old('nama_bidang') }}"
                                placeholder="Masukkan nama bidang">
                            @error('nama_bidang')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="deskripsi">Deskripsi <span class="required">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" required
                                placeholder="Tuliskan deskripsi singkat">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="required">*</span></label>
                            <select class="form-control @error('status_id') is-invalid @enderror" id="status_id"
                                name="status_id" required>
                                <option value="1" {{ old('status_id', 1) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="0" {{ old('status_id') == 0 ? 'selected' : '' }}>
                                    Non-Aktif
                                </option>
                            </select>
                            @error('status_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dibuat_oleh">Dibuat Oleh pada Form Input</label>
                            <input class="form-control" id="dibuat_oleh" name="dibuat_oleh" readonly type="text"
                                value="{{ auth()->user()->name }}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="diubah_oleh">Dibuat Oleh pada Form Edit</label>
                            <input class="form-control" id="diubah_oleh" name="diubah_oleh" readonly type="text"
                                value="{{ auth()->user()->name }}" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="btn btn-secondary" type="button" data-modal-close>Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSubmitBidang">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="btnSubmitText">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('bidangModal');
            const form = document.getElementById('bidangForm');
            const modalTitle = document.getElementById('bidangModalTitle');
            const methodInput = document.getElementById('formMethod');
            const namaBidangInput = document.getElementById('nama_bidang');
            const deskripsiInput = document.getElementById('deskripsi');
            const statusInput = document.getElementById('status_id');
            const dibuatOlehInput = document.getElementById('dibuat_oleh');
            const diubahOlehInput = document.getElementById('diubah_oleh');
            const submitButton = document.getElementById('btnSubmitBidang');
            const submitText = document.getElementById('btnSubmitText');
            const storeUrl = "{{ route('panel.namabidang.store') }}";

            const updateUrlTemplate =
                "{{ route('panel.namabidang.update', ['namabidang' => '__ID__']) }}";

            document.querySelectorAll('[data-modal-open="bidangModal"]').forEach(button => {
                button.addEventListener('click', function() {

                    const mode = this.dataset.modalMode;

                    // Reset tombol setiap modal dibuka
                    submitButton.disabled = false;
                    submitText.textContent = 'Simpan';

                    const icon = submitButton.querySelector('i');

                    if (icon) {
                        icon.className = 'fa-solid fa-floppy-disk';
                    }

                    if (mode === 'create') {

                        modalTitle.textContent = 'Tambah Nama Bidang';
                        form.action = storeUrl;
                        methodInput.value = '';
                        namaBidangInput.value = '';
                        deskripsiInput.value = '';
                        statusInput.value = '1';
                        dibuatOlehInput.closest('.form-group').style.display = '';
                        diubahOlehInput.closest('.form-group').style.display = 'none';

                    } else if (mode === 'edit') {

                        const id = this.dataset.id;
                        modalTitle.textContent = 'Edit Nama Bidang';
                        form.action = updateUrlTemplate.replace('__ID__', id);
                        methodInput.value = 'PUT';
                        namaBidangInput.value = this.dataset.namaBidang;
                        deskripsiInput.value = this.dataset.deskripsi;
                        statusInput.value = this.dataset.statusId;
                        dibuatOlehInput.closest('.form-group').style.display = 'none';
                        diubahOlehInput.closest('.form-group').style.display = '';
                    }
                });
            });

            form.addEventListener('submit', function() {
                // Jangan ubah tombol jika form belum valid
                if (!form.checkValidity()) {
                    return;
                }
                submitButton.disabled = true;
                submitText.textContent = 'Memproses...';
                const icon = submitButton.querySelector('i');
                if (icon) {
                    icon.className = 'fa-solid fa-spinner fa-spin';
                }
            });

        });
    </script>
@endsection
