@extends('administrator.layouts.app')
@section('title', 'Form User dan Hak Akses')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Administrasi / User</span><span>/</span><span aria-current="page">Form User dan Hak Akses</span>
            </nav>
            <h1>Form User dan Hak Akses</h1>
            <p>Buat akun dan tentukan akses modul.</p>
        </div>
        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">
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
            <form id="pamfletForm" method="post" action="{{ route('panel.users.store') }}">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama">Nama <span class="required">*</span></label>
                            <input class="form-control" id="nama" name="nama" type="text"
                                value="{{ old('nama') }}" placeholder="Nama lengkap">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input class="form-control" id="email" name="email" type="email"
                                value="{{ old('email') }}" placeholder="nama@instansi.go.id">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hak_akses">Hak Akses Utama <span class="required">*</span></label>
                            <select class="form-control" id="hak_akses" name="role">
                                <option value="">Pilih Hak Akses</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_baru">Password <span class="required">*</span></label>
                            <input class="form-control" id="password_baru" name="password_baru" minlength="8"
                                type="password" value="" placeholder="Minimal 8 karakter">
                            @error('password_baru')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password <span class="required">*</span></label>
                            <input class="form-control" id="konfirmasi_password" name="password_baru_confirmation"
                                minlength="8" type="password" value="" placeholder="Ulangi password">
                            @error('password_baru_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group full"><label for="permissions">Akses Modul</label>
                            <div class="role-grid">
                                @foreach ($permissions as $permission)
                                    <label class="role-option">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <span>
                                            <strong>{{ ucwords(str_replace('.manage', '', $permission->name)) }}</strong>
                                            <small>
                                                Kelola {{ str_replace('.manage', '', $permission->name) }}
                                            </small>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-section-title"><i class="fa-solid fa-user-pen" aria-hidden="true"></i> Jejak
                        perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="dibuat_oleh">Dibuat Oleh</label>
                            <input class="form-control" id="dibuat_oleh" name="dibuat_oleh" readonly type="text"
                                value="{{ auth()->user()->name ?? '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="diubah_oleh">Diubah Oleh</label>
                            <input class="form-control" id="diubah_oleh" name="diubah_oleh" readonly type="text"
                                value="{{ auth()->user()->name ?? '-' }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
