@extends('administrator.layouts.app')
@section('title', 'Tugas dan Fungsi')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Struktur Organisasi</span>
            </nav>
            <h1>Struktur Organisasi</h1>
            <p>Unggah dan kelola bagan struktur organisasi.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.beranda') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Beranda</a>
        </div>
    </div>
    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div><span class="badge badge-active">Aktif</span>
        </div>
        <div class="card-body">
            <form id="pamfletForm"
                action="{{ $data ? route('panel.struktur-organisasi.update', $data->id) : route('panel.struktur-organisasi.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf

                @if ($data)
                    @method('PUT')
                @endif

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="gambar">Upload Gambar
                                @if (!$data)
                                    <span class="required">*</span>
                                @endif
                            </label>
                            <label class="upload-box {{ $errors->has('gambar') ? 'is-invalid' : '' }}">
                                <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/jpg,image/png"
                                    data-upload {{ !$data ? 'required' : '' }}>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>
                                        {{ $data && $data->gambar ? 'Klik untuk mengganti gambar' : 'Klik atau letakkan berkas di sini' }}
                                    </strong>
                                    <span>JPG dan JPEG, Maksimal 2 MB, Gunakan gambar beresolusi tinggi.</span>
                                </span>
                                <img class="upload-preview" alt="Pratinjau unggahan"
                                    @if ($data && $data->gambar) src="{{ asset('uploads_files/profil/' . $data->gambar) }}"
                                        style="display: block;" @endif>
                            </label>
                            @error('gambar')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror

                            @if ($data && $data->gambar)
                                <div class="form-help" style="margin-top: 8px;">
                                    Gambar saat ini:
                                    <strong>{{ $data->gambar }}</strong>.
                                    Kosongkan kolom upload jika tidak ingin mengganti gambar.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-user-pen" aria-hidden="true"></i> Jejak perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" name="created_by" readonly type="text"
                                value="{{ $data?->created_by ?? auth()->user()->name }}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" name="updated_by" readonly type="text"
                                value="{{ $data?->updated_by ?? auth()->user()->name }}" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.struktur-organisasi.index') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        {{ $data ? 'Simpan perubahan' : 'Simpan data' }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
