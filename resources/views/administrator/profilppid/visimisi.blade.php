@extends('administrator.layouts.app')
@section('title', 'Visi dan Misi PPID')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>PPID</span><span>/</span>
                <span aria-current="page">Visi dan Misi PPID</span>
            </nav>
            <h1>Visi dan Misi PPID</h1>
            <p>Kelola visi dan misi pelayanan informasi publik.</p>
        </div>
        <div class="head-actions"><a class="btn btn-secondary" href="{{ route('panel.beranda') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Beranda</a>
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
                action="{{ $data ? route('panel.visimisippid.update', $data->id) : route('panel.visimisippid.store') }}"
                method="POST">
                @csrf

                @if ($data)
                    @method('PUT')
                @endif

                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="visi">Visi PPID <span class="required">*</span></label>
                            <textarea class="form-control @error('visi') is-invalid @enderror" name="visi" id="visi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('visi', $data?->visi) }}</textarea>
                            @error('visi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="misi">Misi PPID <span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('misi') is-invalid @enderror" name="misi" id="misi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('misi', $data?->misi) }}</textarea>
                            @error('misi')
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
                    <a class="btn btn-secondary" href="{{ route('panel.visimisippid.index') }}">Batal</a>
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
