<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="description" content="Login administrator Portal Informasi Website Dispusarda Provinsi Sulawesi Tengah">
    <meta name="theme-color" content="#0b2f6b">
    <title>Login | Admin Portal Dispusarda Sulteng</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-Sulteng.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <style>
        .swal-poppins {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif !important
        }
    </style>
</head>

<body class="login-body">
    <main class="login-page">
        <section class="login-brand" aria-label="Informasi aplikasi">
            <div class="brand-lockup">
                <span class="brand-mark" aria-hidden="true">DP</span>
                <span class="brand-name">Dispusarda Sulteng<small>Provinsi Sulawesi Tengah</small></span>
            </div>
            <div class="login-copy">
                <span class="eyebrow">Portal Administrasi Terpadu</span>
                <h1>Kelola informasi publik dalam satu ruang kerja.</h1>
                <p>Perpustakaan Hadir Demi Martabat Bangsa, Kearsipan yang Berkelanjutan untuk Masa Depan Terbaik.</p>
                <div class="login-points">
                    <div class="login-point"><i class="fa-solid fa-newspaper" aria-hidden="true"></i><span>Publikasi
                            konten yang teratur</span></div>
                    <div class="login-point"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>Hak akses
                            berbasis peran</span></div>
                    <div class="login-point"><i class="fa-solid fa-chart-line" aria-hidden="true"></i><span>Ringkasan
                            kunjungan aktual</span></div>
                </div>
            </div>
            <p class="login-credit">© 2026 Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah</p>
        </section>
        <section class="login-panel">
            <div class="login-card">
                <span class="eyebrow" style="color:#155cc0">Akses Administrator</span>
                <h2>Selamat datang kembali</h2>
                <p>Masukkan akun yang telah terdaftar untuk melanjutkan ke dashboard.</p>
                <form id="loginForm" method="POST" action="{{ route('panel.login.store') }}" autocomplete="on">
                    @csrf

                    @if (session('status'))
                        <div class="login-note" style="margin-bottom:16px">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="login-note" style="margin-bottom:16px;color:#b42318" role="alert">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="form-group" style="margin-bottom:18px">
                        <label for="email">Alamat email<span class="required">*</span></label>

                        <div class="input-icon">
                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>

                            <input class="form-control" id="email" name="email" type="email"
                                value="{{ old('email') }}" placeholder="nama@instansi.go.id" required autofocus
                                autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password<span class="required">*</span></label>

                        <div class="input-icon">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>

                            <input class="form-control" id="password" name="password" type="password"
                                placeholder="Masukkan password" required autocomplete="current-password"
                                style="padding-right:44px">

                            <button class="password-toggle" type="button" data-password-toggle="password"
                                aria-label="Tampilkan password">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:18px">
                        <label>Verifikasi Keamanan<span class="required">*</span></label>
                        @if (config('panel_security.turnstile.site_key') && config('panel_security.turnstile.secret_key') && config('panel_security.turnstile.expected_hostname'))
                            <div class="cf-turnstile" data-sitekey="{{ config('panel_security.turnstile.site_key') }}"
                                data-theme="light" data-language="id"></div>
                        @else
                            <div class="login-note" role="alert" style="color:#b42318">
                                Verifikasi keamanan belum dikonfigurasi administrator. Login dinonaktifkan.
                            </div>
                        @endif
                    </div>

                    <div class="login-help">
                        <span></span>

                        <a href="#" data-forgot-password style="color:#155cc0;font-weight:600">
                            Lupa password?
                        </a>
                    </div>

                    <button class="btn btn-primary" type="submit" style="width:100%;min-height:48px"
                        @unless (config('panel_security.turnstile.site_key') && config('panel_security.turnstile.secret_key') && config('panel_security.turnstile.expected_hostname')) disabled @endunless>
                        <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i>
                        Masuk ke dashboard
                    </button>
                </form>
                <div class="login-note"><i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                    <span>
                        Silakan Login menggunakan Akun anda yang valid untuk mengelola admin website Dispusaka Pro.
                        Sulteng.
                    </span>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    @if (config('panel_security.turnstile.site_key') && config('panel_security.turnstile.secret_key') && config('panel_security.turnstile.expected_hostname'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
</body>

</html>
