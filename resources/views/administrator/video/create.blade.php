@extends('administrator.layouts.app')
@section('title', 'Form Video')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Form Video</span>
            </nav>
            <h1>Form Video</h1>
            <p>Tambah atau perbarui video kegiatan.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.video.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
    </div>
    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div><span class="badge badge-draft">Draft</span>
        </div>
        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.video.store') }}" method="POST">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul
                                <span class="required">*</span>
                            </label>
                            <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                                type="text" value="{{ old('judul') }}" placeholder="Masukkan judul video">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="linkvideo">Link Video <span class="required">*</span></label>
                            <input class="form-control @error('linkvideo') is-invalid @enderror" id="linkvideo"
                                name="linkvideo" type="url" value="{{ old('linkvideo') }}"
                                placeholder="https://youtube.com/watch?v=...">
                            @error('linkvideo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_upload">Tanggal Upload <span class="required">*</span></label>
                            <input class="form-control @error('tglupload') is-invalid @enderror" id="tglupload"
                                name="tglupload" type="date" value="{{ old('tglupload', date('Y-m-d')) }}">
                            @error('tanggal_upload')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-user-pen" aria-hidden="true"></i> Jejak perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="dibuat_oleh">Dibuat Oleh</label>
                            <input class="form-control" id="dibuat_oleh" type="text" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="diubah_oleh">Status</label>
                            <input class="form-control" id="status_id" type="text" value="Aktif" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.video.create') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
