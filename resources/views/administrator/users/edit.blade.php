@extends('administrator.layouts.app')
@section('title', 'Edit User dan Hak Akses')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Administrasi</span><span>/</span>
                <span aria-current="page">Edit User dan Hak Akses</span>
            </nav>
            <h1>Edit User dan Hak Akses</h1>
            <p>Perbarui data akun dan hak akses pengguna.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>


    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div>
            <span class="badge badge-draft">Edit</span>
        </div>


        <div class="card-body">

            <form id="pamfletForm" method="POST" action="{{ route('panel.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen"></i> Data User
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama">Nama <span class="required">*</span></label>
                            <input class="form-control" id="nama" name="nama" type="text"
                                value="{{ old('nama', $user->name) }}" placeholder="Nama lengkap">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input class="form-control" id="email" name="email" type="email"
                                value="{{ old('email', $user->email) }}" placeholder="nama@instansi.go.id">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hak_akses">Hak Akses Utama <span class="required">*</span></label>
                            <select class="form-control" id="hak_akses" name="role">
                                <option value="">Pilih Hak Akses</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if (old('role', $user->roles->first()?->name) == $role->name) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_baru">Password Baru</label>
                            <input class="form-control" id="password_baru" name="password_baru" type="password"
                                minlength="8" placeholder="Kosongkan jika tidak diganti">
                            @error('password_baru')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password</label>
                            <input class="form-control" id="konfirmasi_password" name="password_baru_confirmation"
                                type="password" minlength="8" placeholder="Ulangi password baru">
                            @error('password_baru_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Akses Modul</label>
                            <div class="role-grid">
                                @foreach ($permissions as $permission)
                                    <label class="role-option">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            @if (in_array($permission->name, old('permissions', $user->permissions->pluck('name')->toArray()))) checked @endif>
                                        <span>
                                            <strong>{{ ucwords(str_replace('.manage', '', $permission->name)) }}</strong>
                                            <small>Kelola {{ str_replace('.manage', '', $permission->name) }}</small>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Jejak perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Dibuat Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ $user->created_by ?? '-' }}">
                        </div>

                        <div class="form-group">
                            <label>Diubah Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ auth()->user()->name ?? '-' }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">Batal</a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span id="submitText">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
