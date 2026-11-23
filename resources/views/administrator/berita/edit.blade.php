@extends('administrator.layouts.app')

@section('title', 'Edit Berita')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.berita.index') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Edit Berita</span>
            </nav>
            <h1>Edit Berita</h1>
            <p>Perbarui data dan konten berita.</p>
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
            @if ($berita->status_id == 1)
                <span class="badge badge-active">
                    Aktif
                </span>
            @else
                <span class="badge badge-inactive">
                    Non-Aktif
                </span>
            @endif
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.berita.update', $berita->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-newspaper" aria-hidden="true"></i>Konten berita
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul Berita<span class="required">*</span></label>
                            <input class="form-control" id="judul" name="judul" type="text" data-slug-source
                                value="{{ old('judul', $berita->judul) }}" placeholder="Masukkan judul berita">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug_judul">Slug Berita<span class="required">*</span></label>
                            <input class="form-control" id="slug_judul" name="slug_judul" type="text" data-slug-target
                                value="{{ old('slug_judul', $berita->slug_judul) }}"
                                placeholder="Slug dibuat otomatis dan dapat disesuaikan." readonly>
                            @error('slug_judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tgl">Tanggal Berita<span class="required">*</span></label>
                            <input class="form-control" id="tgl" name="tgl" type="date"
                                value="{{ old('tgl', optional($berita->tgl)->format('Y-m-d')) }}" required>
                            @error('tgl')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Gambar Utama</label>
                            @if ($berita->gambar)
                                <div style="margin-bottom:12px;">
                                    <img src="{{ asset('uploads_files/berita/' . basename($berita->gambar)) }}"
                                        alt="{{ $berita->judul }}"
                                        style="width:380px;max-width:100%;height:auto;border-radius:8px;display:block;">
                                    <p class="text-danger">
                                        Gambar saat ini. Upload gambar baru hanya jika ingin menggantinya.
                                    </p>
                                </div>
                            @endif

                            <label class="upload-box">
                                <input type="file" name="gambar" id="gambar"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau letakkan gambar baru di sini</strong>
                                    <span>JPG, JPEG, atau PNG.Maksimal 2 MB.</span>
                                </span>
                                <img class="upload-preview" alt="Pratinjau gambar unggahan">
                            </label>
                            <p class="form-hint">
                                Gambar seharusnya JPG, JPEG, atau PNG.Maksimal 2 MB.
                            </p>
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="isi">Isi Berita<span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor" name="isi" id="isi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('isi', $berita->isi) }}</textarea>
                            @error('isi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak perubahan
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="dibaca">Jumlah Pembaca</label>
                            <input class="form-control" id="dibaca" name="dibaca" type="number" min="0"
                                value="{{ old('dibaca', $berita->dibaca ?? 0) }}" readonly>
                            @error('dibaca')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Dibuat Oleh</label>
                            <input class="form-control" type="text" value="{{ $berita->created_by ?? '-' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Terakhir Diubah Oleh</label>
                            <input class="form-control" type="text" value="{{ $berita->updated_by ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.berita.edit', $berita->id) }}">
                        Batal
                    </a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

@endsection
