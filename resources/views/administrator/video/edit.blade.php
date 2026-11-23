@extends('administrator.layouts.app')

@section('title', 'Edit Video')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Edit Video</span>
            </nav>

            <h1>Edit Video</h1>
            <p>Perbarui data video kegiatan.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.video.index') }}">
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

            <span class="badge badge-draft">Edit</span>
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.video.update', $video->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul<span class="required">*</span></label>
                            <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                                type="text" value="{{ old('judul', $video->judul) }}" placeholder="Masukkan judul video">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="linkvideo">Link Video<span class="required">*</span></label>
                            <input class="form-control @error('linkvideo') is-invalid @enderror" id="linkvideo"
                                name="linkvideo" type="url" value="{{ old('linkvideo', $video->linkvideo) }}"
                                placeholder="https://youtube.com/watch?v=...">
                            @error('linkvideo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tglupload">Tanggal Upload<span class="required">*</span></label>
                            <input class="form-control @error('tglupload') is-invalid @enderror" id="tglupload"
                                name="tglupload" type="date" value="{{ old('tglupload', $video->tglupload) }}">
                            @error('tglupload')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Jejak perubahan --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>
                        Jejak perubahan
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="diubah_oleh">Diubah Oleh</label>
                            <input class="form-control" id="diubah_oleh" type="text" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="status_id">Status<span class="required">*</span></label>
                            <select class="form-control @error('status_id') is-invalid @enderror" id="status_id"
                                name="status_id">
                                <option value="1" {{ old('status_id', $video->status_id) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ old('status_id', $video->status_id) == 0 ? 'selected' : '' }}>
                                    Non-aktif
                                </option>
                            </select>
                            @error('status_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.video.edit', $video->id) }}">
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
@endsection
