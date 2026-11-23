@extends('administrator.layouts.app')
@section('title', 'Akun Saya')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Akun</span><span>/</span>
                <span aria-current="page">Akun Saya</span>
            </nav>
            <h1>Akun Saya</h1>
            <p>Perbarui data profil dan keamanan akun yang sedang login.</p>
        </div>

    </div>
    <section class="card form-card">
        <div class="card-body">
            @if (session('status'))
                <div class="login-note" role="status">{{ session('status') }}</div>
            @endif
            <div class="account-panel active" data-account-panel="profil">
                <form method="POST" action="{{ route('panel.akun.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fa-solid fa-user-pen"></i> Data Profil Akun
                        </div>
                        <div class="form-grid">
                            <div class="form-group full">
                                <label for="role">Role</label>
                                <input class="form-control" id="role" readonly type="text"
                                    value="{{ $user->roles->pluck('name')->join(', ') }}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="required">*</span></label>
                                <input class="form-control" id="name" name="name" type="text" required maxlength="255" autocomplete="name"
                                    value="{{ old('name', $user->name) }}" placeholder="">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <input class="form-control" id="email" name="email" type="email" required maxlength="255" autocomplete="email"
                                    value="{{ old('email', $user->email) }}" placeholder="">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fa-solid fa-lock"></i> Ubah Password
                        </div>
                        <div class="form-grid">
                            <div class="form-group full">
                                <label for="password_lama">Password Lama <span class="required">*</span></label>
                                <div class="input-icon">
                                    <input class="form-control password-field" id="password_lama" name="password_lama"
                                        type="password" required autocomplete="current-password" placeholder="Masukkan password lama">

                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('password_lama', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>

                                @error('password_lama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_baru">Password Baru <small>(opsional, minimal 12 karakter)</small></label>
                                <div class="input-icon">
                                    <input class="form-control password-field" id="password_baru" name="password_baru"
                                        minlength="12" type="password" autocomplete="new-password" placeholder="Masukkan password baru">

                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('password_baru', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>

                                @error('password_baru')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="konfirmasi_password">Konfirmasi Password Baru
                                </label>

                                <div class="input-icon">
                                    <input class="form-control password-field" id="konfirmasi_password"
                                        name="password_baru_confirmation" minlength="12" type="password" autocomplete="new-password"
                                        placeholder="Konfirmasi password baru">

                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('konfirmasi_password', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>

                                @error('password_baru_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function togglePassword(id, button) {
            const input = document.getElementById(id);
            const icon = button.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
