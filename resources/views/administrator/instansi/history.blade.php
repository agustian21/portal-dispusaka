@extends('administrator.layouts.app')
@section('title', 'Sejarah Dinas')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Sejarah Dinas</span>
            </nav>
            <h1>Sejarah Dinas</h1>
            <p>Kelola narasi sejarah berdirinya dinas.</p>
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
                action="{{ $data ? route('panel.sejarah-dinas.update', $data->id) : route('panel.sejarah-dinas.store') }}"
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
                            <label for="sejarah_instansi">Deskripsi Tentang Sejarah Berdirinya Dinas <span
                                    class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('sejarah_instansi') is-invalid @enderror" name="sejarah_instansi"
                                id="sejarah_instansi" placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('sejarah_instansi', $data?->sejarah_instansi) }}</textarea>
                            @error('sejarah_instansi')
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
