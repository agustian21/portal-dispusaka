@extends('administrator.layouts.app')
@section('title', 'Form FAQ Layanan')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Administrasi</span><span>/</span>
                <span aria-current="page">Form FAQ Layanan</span>
            </nav>
            <h1>Form FAQ Layanan</h1>
            <p>Tambah atau perbarui pertanyaan layanan.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.faqlayanan.index') }}">
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
            <form id="pamfletForm" action="{{ route('panel.faqlayanan.store') }}" method="POST">
                @csrf
                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul Pertanyaan <span class="required">*</span></label>
                            <input class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                                type="text" value="{{ old('judul') }}" placeholder="Pertanyaan yang sering diajukan">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="isi">Jawaban <span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('isi') is-invalid @enderror" id="isi" name="isi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('isi') }}</textarea>
                            @error('isi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i> Jejak perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by_display" type="text"
                                value="{{ Auth::user()->name ?? '-' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" name="updated_by" readonly type="text"
                                value="{{ Auth::user()->name ?? '-' }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.faqlayanan.create') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
