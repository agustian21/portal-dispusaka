@extends('administrator.layouts.app')
@section('title', 'Form Profil Pejabat')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Form Profil Pejabat</span>
            </nav>
            <h1>Form Profil Pejabat</h1>
            <p>Tambah atau perbarui data pejabat.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.data-pejabat.index') }}">
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
            <form id="pamfletForm" action="{{ route('panel.data-pejabat.store') }}" method="POST"
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
                            <span class="text-danger">Gambar wajib JPG, JPEG atau PNG. Maksimal 3 MB.Rasio potret
                                disarankan.</span>
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
                            <label for="nip">NIP <span class="required">*</span></label>
                            <input class="form-control" id="nip" name="nip" type="text" inputmode="numeric"
                                maxlength="18" value="{{ old('nip') }}" placeholder="18 digit NIP" autocomplete="off">
                            @error('nip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pangkat">Pangkat/Golongan <span class="required">*</span></label>
                            <input class="form-control" id="pangkat" name="pangkat" type="text"
                                value="{{ old('pangkat') }}" placeholder="Contoh: Pembina / IV.a" autocomplete="off">
                            @error('pangkat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan <span class="required">*</span></label>
                            <select class="form-control" id="jabatan" name="jabatan">
                                <option value="">-- Pilih Jabatan --</option>

                                <option value="Kepala Dinas" {{ old('jabatan') == 'Kepala Dinas' ? 'selected' : '' }}>
                                    Kepala Dinas
                                </option>

                                <option value="Sekretaris Dinas"
                                    {{ old('jabatan') == 'Sekretaris Dinas' ? 'selected' : '' }}>
                                    Sekretaris Dinas
                                </option>

                                <option value="Kepala Bidang" {{ old('jabatan') == 'Kepala Bidang' ? 'selected' : '' }}>
                                    Kepala Bidang
                                </option>

                                <option value="Kepala Sub.Bagian"
                                    {{ old('jabatan') == 'Kepala Sub.Bagian' ? 'selected' : '' }}>
                                    Kepala Sub.Bagian
                                </option>

                                <option value="Pustakawan Ahli Madya"
                                    {{ old('jabatan') == 'Pustakawan Ahli Madya' ? 'selected' : '' }}>
                                    Pustakawan Ahli Madya
                                </option>

                                <option value="Arsiparis Ahli Madya"
                                    {{ old('jabatan') == 'Arsiparis Ahli Madya' ? 'selected' : '' }}>
                                    Arsiparis Ahli Madya
                                </option>
                            </select>
                            @error('jabatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="namabidang_id">Bidang <span class="required">*</span></label>
                            <select class="form-control" id="namabidang_id" name="namabidang_id">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($namabidang as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ old('namabidang_id') == $bidang->id ? 'selected' : '' }}>

                                        {{ $bidang->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('namabidang_id')
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
                    <a class="btn btn-secondary" href="{{ route('panel.data-pejabat.create') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
