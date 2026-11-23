@extends('administrator.layouts.app')
@section('title', 'Alamat Instansi')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>PPID</span><span>/</span>
                <span aria-current="page">Alamat Instansi</span>
            </nav>
            <h1>Alamat Instansi</h1>
            <p>Kelola Kedudukan/Domisili Beserta Alamat Lengkap.</p>
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
                action="{{ $data ? route('panel.alamat.update', $data->id) : route('panel.alamat.store') }}" method="POST">
                @csrf

                @if ($data)
                    @method('PUT')
                @endif

                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama">Nama Instansi <span class="required">*</span></label>
                            <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                type="text" value="{{ $data?->nama ?? ($data?->nama ?? '-') }}">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="singkatan">Singkatan Instansi <span class="required">*</span></label>
                            <input class="form-control @error('singkatan') is-invalid @enderror" id="singkatan"
                                name="singkatan" type="text"
                                value="{{ $data?->singkatan ?? ($data?->singkatan ?? '-') }}">
                            @error('singkatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="alamat">Alamat Instansi <span class="required">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('alamat', $data?->alamat) }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Instansi <span class="required">*</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="text" value="{{ $data?->email ?? ($data?->email ?? '-') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telepon">Telepon Instansi</label>
                            <input class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon"
                                type="text" value="{{ $data?->telepon ?? ($data?->telepon ?? '-') }}">
                            @error('telepon')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="link_maps">Link Google Maps</label>
                            <input class="form-control @error('link_maps') is-invalid @enderror" id="link_maps"
                                name="link_maps" type="text"
                                value="{{ $data?->link_maps ?? ($data?->link_maps ?? '-') }}">
                            @error('link_maps')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="facebook">Link Facebook</label>
                            <input class="form-control @error('facebook') is-invalid @enderror" id="facebook"
                                name="facebook" type="text" value="{{ $data?->facebook ?? ($data?->facebook ?? '-') }}">
                            @error('facebook')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instagram">Link Instagram</label>
                            <input class="form-control @error('instagram') is-invalid @enderror" id="instagram"
                                name="instagram" type="text"
                                value="{{ $data?->instagram ?? ($data?->instagram ?? '-') }}">
                            @error('instagram')
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
                    <a class="btn btn-secondary" href="{{ route('panel.alamat.index') }}">Batal</a>
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
