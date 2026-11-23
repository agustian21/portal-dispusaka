@extends('administrator.layouts.app')
@section('title', 'Kategori PPID')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Pengaturan</span><span>/</span>
                <span aria-current="page">Kategori PPID</span>
            </nav>
            <h1>Kategori PPID</h1>
            <p>Kelola referensi kategori PPID untuk pengelompokan data.</p>
        </div>
        <div class="head-actions">
            <button class="btn btn-primary" type="button" data-modal-open="katppidModal" data-modal-mode="create"
                data-entity="Kategori PPID">
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
                        <th data-sort="text">Kategori PPID</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriPpid as $key => $item)
                        <tr>
                            <td data-sort-value="{{ $key + 1 }}">{{ $key + 1 }}</td>
                            <td>
                                <div class="cell-title">{{ $item->nm_ppid }}</div>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button class="action-btn" type="button" data-modal-open="katppidModal"
                                        data-modal-mode="edit" data-id="{{ $item->id }}"
                                        data-nama-katppid="{{ $item->nm_ppid }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('panel.katppid.destroy', $item->id) }}" method="POST"
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

    <div class="modal" id="katppidModal" role="dialog" aria-modal="true" aria-labelledby="katppidModalTitle"
        aria-hidden="true">
        <div class="modal-backdrop"></div>
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h2 id="katppidModalTitle" data-modal-title>Tambah Kategori PPID</h2>
                    <p>Form modal khusus data referensi pengaturan.</p>
                </div>
                <button class="modal-close" type="button" data-modal-close aria-label="Tutup modal">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
            <form id="katppidForm" method="POST" action="{{ route('panel.katppid.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="">
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="nm_ppid">Nama Kategori PPID<span class="required">*</span></label>
                            <input class="form-control @error('nm_ppid') is-invalid @enderror" id="nm_ppid" name="nm_ppid"
                                required type="text" value="{{ old('nm_ppid') }}"
                                placeholder="Masukkan nama kategori PPID">
                            @error('nm_ppid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="btn btn-secondary" type="button" data-modal-close>Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSubmitKatppid">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="btnSubmitText">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('katppidModal');
            const form = document.getElementById('katppidForm');
            const modalTitle = document.getElementById('katppidModalTitle');
            const methodInput = document.getElementById('formMethod');
            const namaKatppidInput = document.getElementById('nm_ppid');
            const submitButton = document.getElementById('btnSubmitKatppid');
            const submitText = document.getElementById('btnSubmitText');
            const storeUrl = "{{ route('panel.katppid.store') }}";
            const updateUrlTemplate =
                "{{ route('panel.katppid.update', ['katppid' => '__ID__']) }}";

            document.querySelectorAll('[data-modal-open="katppidModal"]').forEach(button => {
                button.addEventListener('click', function() {

                    const mode = this.dataset.modalMode;

                    // reset tombol
                    submitButton.disabled = false;
                    submitText.textContent = 'Simpan';

                    const icon = submitButton.querySelector('i');

                    if (icon) {
                        icon.className = 'fa-solid fa-floppy-disk';
                    }

                    if (mode === 'create') {
                        modalTitle.textContent = 'Tambah Nama Kategori PPID';
                        form.action = storeUrl;
                        methodInput.value = '';
                        namaKatppidInput.value = '';

                    } else if (mode === 'edit') {

                        const id = this.dataset.id;
                        const namaKatppid = this.dataset.namaKatppid;

                        modalTitle.textContent = 'Edit Nama Kategori PPID';
                        form.action = updateUrlTemplate.replace('__ID__', id);
                        methodInput.value = 'PUT';
                        namaKatppidInput.value = namaKatppid;
                    }
                });
            });

            form.addEventListener('submit', function() {
                // Biarkan validasi HTML berjalan dahulu
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
