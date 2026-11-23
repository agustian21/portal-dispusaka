@extends('administrator.layouts.app')
@section('title', 'Tugas dan Tanggung Jawab PPID')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>PPID</span><span>/</span>
                <span aria-current="page">Tugas dan Tanggung Jawab PPID</span>
            </nav>
            <h1>Tugas dan Tanggung Jawab PPID</h1>
            <p>Kelola uraian tugas dan tanggung jawab PPID Utama dan PPID Pelaksana.</p>
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
                action="{{ $data ? route('panel.tugasppid.update', $data->id) : route('panel.tugasppid.store') }}"
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
                            <label for="tugasutama">Tugas dan Tanggung Jawab PPID Utama <span
                                    class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('tugasutama') is-invalid @enderror" name="tugasutama"
                                id="tugasutama" placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('tugasutama', $data?->tugasutama) }}</textarea>
                            @error('tugasutama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="tugaspelaksana">Tugas dan Tanggung Jawab PPID Pelaksana <span
                                    class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('tugaspelaksana') is-invalid @enderror" name="tugaspelaksana"
                                id="tugaspelaksana" placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('tugaspelaksana', $data?->tugaspelaksana) }}</textarea>
                            @error('tugaspelaksana')
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
                    <a class="btn btn-secondary" href="{{ route('panel.tugasppid.index') }}">Batal</a>
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
