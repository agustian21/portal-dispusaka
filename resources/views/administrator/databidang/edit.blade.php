```blade
@extends('administrator.layouts.app')
@section('title', 'Edit Data Bidang')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Edit Data Bidang</span>
            </nav>

            <h1>Edit Data Bidang</h1>
            <p>Perbarui data dokumen publikasi bidang.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.databidang.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Kembali
            </a>
        </div>
    </div>


    <section class="card form-card">

        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div>

            @if ($databidang->status_id == 1)
                <span class="badge badge-active">Status : Aktif</span>
            @else
                <span class="badge badge-inactive">Status : Non-aktif</span>
            @endif
        </div>


        <div class="card-body">

            <form id="ppidForm" method="POST" action="{{ route('panel.databidang.update', $databidang->id) }}">
                @csrf
                @method('PUT')
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        Data Konten
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="judul">Judul<span class="required">*</span></label>
                            <input class="form-control" id="judul" name="judul" type="text"
                                value="{{ old('judul', $databidang->judul) }}" placeholder="Judul dokumen" maxlength="255">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="namabidang_id">Bidang<span class="required">*</span></label>
                            <select class="form-control" id="namabidang_id" name="namabidang_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($namabidang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('namabidang_id', $databidang->namabidang_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('namabidang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="file">Link Google Drive<span class="required">*</span></label>
                            <input class="form-control" id="file" name="file" type="url"
                                value="{{ old('file', $databidang->file) }}"
                                placeholder="https://drive.google.com/file/d/..." autocomplete="off" required>
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if ($databidang->file)
                                <div style="margin-top:8px;">
                                    <a href="{{ $databidang->file }}" target="_blank" rel="noopener noreferrer"
                                        style="color:#155cc0;font-weight:600;">
                                        <i class="fa-brands fa-google-drive" aria-hidden="true"
                                            style="margin-right:6px;"></i>
                                        Buka dokumen saat ini
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak Perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" type="text"
                                value="{{ $databidang->created_by ?? '-' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" type="text" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.ppid.index') }}">
                        Batal
                    </a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('ppidForm');
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');

            if (!form || !submitButton || !submitText) {
                return;
            }

            form.addEventListener('submit', function() {

                if (!form.checkValidity()) {
                    return;
                }

                const icon = submitButton.querySelector('i');

                if (icon) {
                    icon.classList.remove('fa-floppy-disk');
                    icon.classList.add('fa-spinner', 'fa-spin');
                }

                submitText.textContent = 'Memproses...';
                submitButton.disabled = true;

            });

        });
    </script>

@endsection
```
