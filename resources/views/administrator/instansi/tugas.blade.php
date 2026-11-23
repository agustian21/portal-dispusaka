@extends('administrator.layouts.app')
@section('title', 'Tugas dan Fungsi')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Tugas dan Fungsi</span>
            </nav>
            <h1>Tugas dan Fungsi</h1>
            <p>Kelola uraian tugas pokok dan fungsi dinas.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.beranda') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Beranda
            </a>
        </div>
    </div>
    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div>
            <span class="badge badge-active">Baru</span>
        </div>
        <div class="card-body">
            <form id="pamfletForm"
                action="{{ $data ? route('panel.tugas-fungsi.update', $data->id) : route('panel.tugas-fungsi.store') }}"
                method="POST">
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
                            <label for="tugas_fungsi">Deskripsi Tentang Tugas dan Fungsi Dinas <span
                                    class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('tugas_fungsi') is-invalid @enderror" name="tugas_fungsi"
                                id="tugas_fungsi" placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('tugas_fungsi', $data?->tugas_fungsi) }}</textarea>
                            @error('tugas_fungsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group full">
                            <label for="link_google">Link Google Drive</label>
                            <input class="form-control @error('link_google') is-invalid @enderror" id="link_google"
                                name="link_google" type="url" value="{{ old('link_google', $data?->link_google) }}"
                                placeholder="https://drive.google.com/file/d/...">
                            <div class="drive-preview" id="drivePreview" aria-live="polite">
                                <div class="drive-preview-head">
                                    <div class="drive-preview-title"><i class="fa-brands fa-google-drive"
                                            aria-hidden="true"></i><span>Pratinjau Google Drive</span></div><a
                                        class="drive-preview-open" id="drivePreviewOpen" href="#" target="_blank"
                                        rel="noopener noreferrer"><i class="fa-solid fa-arrow-up-right-from-square"
                                            aria-hidden="true"></i> Buka Drive</a>
                                </div><iframe class="drive-preview-frame" id="drivePreviewFrame"
                                    title="Pratinjau file Google Drive" loading="lazy"
                                    referrerpolicy="no-referrer"></iframe>
                                <div class="drive-preview-message" id="drivePreviewMessage">Masukkan tautan Google Drive
                                    yang valid agar pratinjau dapat ditampilkan.</div>
                            </div>
                            @error('link_google')
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
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" name="created_by" readonly type="text"
                                value="{{ $data?->created_by ?? ($data?->updated_by ?? '-') }}">
                        </div>
                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" name="updated_by" readonly type="text"
                                value="{{ $data?->updated_by ?? '-' }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.sejarah-dinas.index') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">
                            {{ $data ? 'Simpan perubahan' : 'Simpan data' }}
                        </span>
                    </button>

                </div>
            </form>
        </div>
    </section>
@endsection
