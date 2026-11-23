@extends('administrator.layouts.app')
@section('title', 'Form Pejabat Dari Masa Ke Masa')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Form Pejabat Dari Masa Ke Masa</span>
            </nav>
            <h1>Form Pejabat Dari Masa Ke Masa</h1>
            <p>Tambah atau perbarui data pejabat.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.data-kadis.index') }}">
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
            <form id="pamfletForm" action="{{ route('panel.data-kadis.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="foto">Foto <span class="required">*</span></label>
                            <label class="upload-box">
                                <input type="file" id="foto" name="foto"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau letakkan berkas di sini</strong>
                                    <span>JPG, JPEG atau PNG. Maksimal 3 MB.Rasio potret disarankan.</span>
                                </span>
                                <img class="upload-preview" alt="Pratinjau unggahan">
                            </label>
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="nama">Nama Pejabat <span class="required">*</span></label>
                            <input class="form-control" id="nama" name="nama" type="text"
                                value="{{ old('nama') }}" placeholder="Nama lengkap dan gelar" autocomplete="off">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="periode">Periode <span class="required">*</span></label>
                            <input class="form-control" id="periode" name="periode" type="text"
                                value="{{ old('periode') }}" placeholder="Masukkan periode kepala dinas" autocomplete="off">
                            @error('periode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="jabatan">Jabatan <span class="required">*</span></label>
                            <input class="form-control" id="jabatan" name="jabatan" type="text"
                                value="{{ old('jabatan') }}" placeholder="Masukkan jabatan kepala dinas" autocomplete="off">
                            @error('jabatan')
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
                            <input class="form-control" id="created_by" name="created_by" readonly type="text"
                                value="{{ auth()->user()->name }}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" name="updated_by" readonly type="text"
                                value="{{ auth()->user()->name }}" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.data-kadis.store') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
