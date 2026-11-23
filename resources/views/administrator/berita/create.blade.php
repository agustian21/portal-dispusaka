@extends('administrator.layouts.app')

@section('title', 'Form Berita')

@section('contents')

    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.berita.index') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Form Berita</span>
            </nav>
            <h1>Form Berita</h1>
            <p>Tambah berita baru atau perbarui konten yang sudah tersedia.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.berita.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>Kembali
            </a>
        </div>
    </div>

    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div>
            <span class="badge badge-draft">Baru</span>
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-newspaper" aria-hidden="true"></i>Konten berita
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul Berita<span class="required">*</span></label>
                            <input class="form-control" id="judul" name="judul" type="text" data-slug-source
                                value="{{ old('judul') }}" placeholder="Masukkan judul berita">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug_judul">Slug Berita<span class="required">*</span></label>
                            <input class="form-control" id="slug_judul" name="slug_judul" type="text" data-slug-target
                                value="{{ old('slug_judul') }}" placeholder="Slug dibuat otomatis dan dapat disesuaikan."
                                readonly>
                            @error('slug_judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tgl">Tanggal Berita<span class="required">*</span></label>
                            <input class="form-control" id="tgl" name="tgl" type="date"
                                value="{{ old('tgl', now()->format('Y-m-d')) }}">
                            @error('tgl')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Gambar Utama<span class="required">*</span></label>
                            <label class="upload-box">
                                <input type="file" name="gambar" id="gambar" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau letakkan gambar di sini</strong>
                                    <span>JPG, JPEG, atau PNG. Maksimal 2 MB.</span>
                                </span>
                                <img class="upload-preview" alt="Pratinjau gambar unggahan">
                            </label>
                            <p class="form-hint">Gambar seharusnya JPG, JPEG, atau PNG. Maksimal 2 MB.</p>
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">

                            <label for="isi">Isi Berita<span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor" name="isi" id="isi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('isi') }}</textarea>
                            @error('isi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <p class="text-danger">
                            Perhatian : <br>
                            Contoh Pengambilan Gambar di Google Drive : https://lh3.googleusercontent.com/d/Nomor_ID
                        </p>
                    </div>
                </div>

                {{-- JEJAK PERUBAHAN --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak perubahan
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="dibaca">Jumlah Pembaca</label>
                            <input class="form-control" id="dibaca" name="dibaca" type="number" min="0"
                                value="{{ old('dibaca', 0) }}" readonly>
                            @error('dibaca')
                                <p class="form-hint">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Dibuat Oleh</label>
                            <input class="form-control" type="text" value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Diubah Oleh</label>
                            <input class="form-control" type="text" value="{{ auth()->user()->name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.berita.create') }}">
                        Batal
                    </a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

@endsection