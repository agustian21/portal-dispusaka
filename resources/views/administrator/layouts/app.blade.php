<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Logo-Sulteng.png') }}">
    <meta name="description" content="Pantau publikasi, layanan PPID, dan kunjungan portal dari satu tampilan.">
    <meta name="theme-color" content="#0b2f6b">
    <title>@yield('title', 'Website Admin Dispusaka Prov. Sulteng')</title>
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

@php
    $informasiActive = request()->routeIs('panel.video.*', 'panel.pamflet.*', 'panel.databidang.*', 'panel.berita.*');

    $profilActive = request()->routeIs(
        'panel.sejarah-dinas.*',
        'panel.visi-misi-instansi.*',
        'panel.tugas-fungsi.*',
        'panel.struktur-organisasi.*',
        'panel.data-kadis.*',
        'panel.profil-pejabat.*',
    );

    $ppidActive = request()->routeIs('panel.visimisippid.*', 'panel.tugasppid.*', 'panel.ppid.*', 'panel.alamat.*');

    $settingsActive = request()->routeIs('panel.namabidang.*', 'panel.katppid.*', 'panel.buku-tamu.*');
@endphp

<body>
    <a class="skip-link" href="#mainContent">Lewati ke konten utama</a>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar" aria-label="Navigasi utama">
            <div class="sidebar-head">
                <div class="brand-lockup">
                    <span class="brand-mark" aria-hidden="true">DP</span>
                    <span class="brand-name">Dispusaka Sulteng<small>Provinsi Sulawesi Tengah</small></span>
                </div>
                <button class="sidebar-close" id="sidebarClose" type="button" aria-label="Tutup navigasi">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <p class="nav-label">Utama</p>
                <a class="nav-link {{ request()->routeIs('panel.beranda') ? 'active' : '' }}"
                    href="{{ route('panel.beranda') }}">
                    <i class="fa-solid fa-house"
                        aria-hidden="{{ $informasiActive ? 'true' : 'false' }}"></i><span>Beranda</span>
                </a>

                <p class="nav-label">Kelola Konten</p>
                @canany(['berita.manage', 'video.manage', 'pamflet.manage', 'slider-website.manage'])
                    <button class="nav-toggle {{ $informasiActive ? 'active' : '' }}" type="button"
                        data-nav-toggle="nav-informasi" aria-expanded="false">
                        <i class="fa-solid fa-newspaper" aria-hidden="true"></i><span>Informasi</span>
                        <i class="fa-solid fa-chevron-down chevron" aria-hidden="true"></i>
                    </button>
                    <div class="nav-sub {{ $informasiActive ? 'open' : '' }}" id="nav-informasi">
                        @can('berita.manage')
                            <a class="{{ request()->routeIs('panel.berita.*') ? 'active' : '' }}"
                                href="{{ route('panel.berita.index') }}">Berita</a>
                        @endcan
                        @can('video.manage')
                            <a class="{{ request()->routeIs('panel.video.*') ? 'active' : '' }}"
                                href="{{ route('panel.video.index') }}">Video</a>
                        @endcan
                        @can('pamflet.manage')
                            <a class="{{ request()->routeIs('panel.pamflet.*') ? 'active' : '' }}"
                                href="{{ route('panel.pamflet.index') }}">Pengumuman / Pamflet</a>
                        @endcan
                        @can('slider-website.manage')
                            <a class="{{ request()->routeIs('panel.slider-website.*') ? 'active' : '' }}"
                                href="{{ route('panel.slider-website.index') }}">Slider Website</a>
                        @endcan
                        <a class="{{ request()->routeIs('panel.databidang.*') ? 'active' : '' }}"
                            href="{{ route('panel.databidang.index') }}">Galeri</a>
                    </div>
                @endcanany

                @canany(['sejarah-dinas.manage', 'visi-misi-instansi.manage', 'tugas-fungsi.manage',
                    'struktur-organisasi.manage', 'data-kadis.manage', 'data-pejabat.manage'])
                    <button class="nav-toggle {{ $profilActive ? 'active' : '' }}" type="button"
                        data-nav-toggle="nav-profil" aria-expanded="false">
                        <i class="fa-solid fa-building-columns" aria-hidden="{{ $profilActive ? 'true' : 'false' }}"></i>
                        <span>Profil Dinas</span>
                        <i class="fa-solid fa-chevron-down chevron" aria-hidden="true"></i>
                    </button>
                    <div class="nav-sub {{ $profilActive ? 'open' : '' }}" id="nav-profil">
                        @can('sejarah-dinas.manage')
                            <a class="{{ request()->routeIs('panel.sejarah-dinas.*') ? 'active' : '' }}"
                                href="{{ route('panel.sejarah-dinas.index') }}">Sejarah Dinas</a>
                        @endcan
                        @can('visi-misi-instansi.manage')
                            <a class="{{ request()->routeIs('panel.visi-misi-instansi.*') ? 'active' : '' }}"
                                href="{{ route('panel.visi-misi-instansi.index') }}">Visi dan Misi</a>
                        @endcan
                        @can('tugas-fungsi.manage')
                            <a class="{{ request()->routeIs('panel.tugas-fungsi.*') ? 'active' : '' }}"
                                href="{{ route('panel.tugas-fungsi.index') }}">Tugas dan Fungsi</a>
                        @endcan
                        @can('struktur-organisasi.manage')
                            <a class="{{ request()->routeIs('panel.struktur-organisasi.*') ? 'active' : '' }}"
                                href="{{ route('panel.struktur-organisasi.index') }}">Struktur Organisasi</a>
                        @endcan
                        @can('data-kadis.manage')
                            <a class="{{ request()->routeIs('panel.data-kadis.*') ? 'active' : '' }}"
                                href="{{ route('panel.data-kadis.index') }}">Periode Pejabat Dinas</a>
                        @endcan
                        @can('profil-pejabat.manage')
                            <a class="{{ request()->routeIs('panel.profil-pejabat.*') ? 'active' : '' }}"
                                href="{{ route('panel.data-pejabat.index') }}">Profil Pejabat</a>
                        @endcan
                    </div>
                @endcanany

                @canany(['visimisippid.manage', 'tugasppid.manage', 'ppid.manage', 'alamat.manage'])
                    <button class="nav-toggle {{ $ppidActive ? 'active' : '' }}" type="button" data-nav-toggle="nav-ppid"
                        aria-expanded="{{ $ppidActive ? 'true' : 'false' }}">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        <span>PPID</span>
                        <i class="fa-solid fa-chevron-down chevron" aria-hidden="true"></i>
                    </button>

                    <div class="nav-sub {{ $ppidActive ? 'open' : '' }}" id="nav-ppid">
                        @can('visimisippid.manage')
                            <a class="{{ request()->routeIs('panel.visimisippid.*') ? 'active' : '' }}"
                                href="{{ route('panel.visimisippid.index') }}">Visi dan Misi</a>
                        @endcan
                        @can('tugasppid.manage')
                            <a class="{{ request()->routeIs('panel.tugasppid.*') ? 'active' : '' }}"
                                href="{{ route('panel.tugasppid.index') }}">Tugas dan Tanggung Jawab</a>
                        @endcan
                        @can('ppid.manage')
                            <a class="{{ request()->routeIs('panel.ppid.*') ? 'active' : '' }}"
                                href="{{ route('panel.ppid.index') }}">Informasi Publik</a>
                        @endcan
                        @can('alamat.manage')
                            <a class="{{ request()->routeIs('panel.alamat.*') ? 'active' : '' }}"
                                href="{{ route('panel.alamat.index') }}">Alamat Instansi</a>
                        @endcan
                    </div>
                @endcanany

                <p class="nav-label">Administrasi</p>
                @can('users.manage')
                    <a class="nav-link {{ request()->routeIs('panel.users.*') ? 'active' : '' }}"
                        href="{{ route('panel.users.index') }}">
                        <i class="fa-solid fa-users-gear" aria-hidden="true"></i><span>User dan Role</span>
                    </a>
                @endcan
                @can('faq.manage')
                    <a class="nav-link {{ request()->routeIs('panel.faqlayanan.*') ? 'active' : '' }}"
                        href="{{ route('panel.faqlayanan.index') }}">
                        <i class="fa-solid fa-circle-question" aria-hidden="true"></i><span>FAQ Layanan</span>
                    </a>
                @endcan
                @can('settings.manage')
                    <button class="nav-toggle {{ $settingsActive ? 'active' : '' }}" type="button"
                        data-nav-toggle="nav-settings" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                        <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                        <span>Pengaturan Umum</span>
                        <i class="fa-solid fa-chevron-down chevron" aria-hidden="true"></i>
                    </button>
                    <div class="nav-sub {{ $settingsActive ? 'open' : '' }}" id="nav-settings">
                        <a class="{{ request()->routeIs('panel.namabidang.*') ? 'active' : '' }}"
                            href="{{ route('panel.namabidang.index') }}">Nama Bidang</a>
                        <a class="{{ request()->routeIs('panel.katppid.*') ? 'active' : '' }}"
                            href="{{ route('panel.katppid.index') }}">Kategori PPID</a>
                        <a class="{{ request()->routeIs('panel.buku-tamu.*') ? 'active' : '' }}"
                            href="{{ route('panel.buku-tamu.index') }}">Buku Tamu</a>
                    </div>
                @endcan
            </nav>

            <div class="sidebar-foot">
                <div class="sidebar-foot-card">
                    <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                    <span>Di buat oleh : <br> Agustian Lagentu, S.Kom.</span>
                </div>
            </div>

        </aside>
        <div class="overlay" id="overlay"></div>
        <div class="main-wrap">
            <header class="topbar">
                <button class="menu-btn" id="menuButton" type="button" aria-label="Buka navigasi"
                    aria-expanded="false"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
                <div class="topbar-title">
                    <p>Portal Informasi Website</p><strong>@yield('title')</strong>
                </div>
                <div class="topbar-actions">
                    <button class="icon-btn" type="button" aria-label="Pencarian cepat">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </button>
                    <button class="icon-btn notification-dot" type="button" aria-label="3 notifikasi baru">
                        <i class="fa-regular fa-bell" aria-hidden="true"></i>
                    </button>
                    <div class="user-menu">
                        <button class="user-trigger" id="userTrigger" type="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="avatar" aria-hidden="true">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                            <span class="user-copy">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small>Superadmin</small>
                            </span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"
                                style="font-size:9px;color:#8793a5"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="{{ route('panel.akun.index') }}"><i class="fa-regular fa-user"
                                    aria-hidden="true"></i> Ubah
                                profil</a>
                            <hr>
                            <button class="danger" type="button" data-logout>
                                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>Keluar
                            </button>

                            <form id="panelLogoutForm" action="{{ route('panel.logout') }}" method="POST" hidden>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="content" id="mainContent">
                @yield('contents')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce.js') }}"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            });
        </script>
    @endif


    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif
    <script>
        (() => {
            'use strict';
            const IDLE_TIMEOUT = 2 * 60 * 60 * 1000;
            const HEARTBEAT_INTERVAL = 5 * 60 * 1000;
            const ACTIVITY_KEY = 'dispusarda_panel_last_activity';
            const logoutForm =
                document.getElementById('panelLogoutForm');
            const logoutButton =
                document.getElementById('panelLogoutButton');
            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                )?.content;
            let lastHeartbeat = Date.now();
            let heartbeatRunning = false;

            /**
             * Logout melalui POST + CSRF.
             */
            const logout = () => {
                localStorage.removeItem(ACTIVITY_KEY);
                if (logoutForm) {
                    logoutForm.requestSubmit();
                }
            };

            /**
             * Sinkronkan aktivitas browser dengan session server.
             *
             * Maksimal satu request setiap 5 menit.
             */
            const heartbeat = async () => {
                const now = Date.now();
                if (
                    heartbeatRunning ||
                    now - lastHeartbeat < HEARTBEAT_INTERVAL
                ) {
                    return;
                }

                heartbeatRunning = true;
                try {
                    const response = await fetch(
                        @json(route('panel.activity')), {
                            method: 'POST',
                            credentials: 'same-origin',

                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                        }
                    );

                    if (
                        response.redirected ||
                        response.status === 401 ||
                        response.status === 419
                    ) {
                        window.location.href =
                            @json(route('login'));

                        return;
                    }

                    if (response.ok) {
                        lastHeartbeat = Date.now();
                    }
                } catch (error) {
                    // Jangan memperpanjang session jika koneksi gagal.
                    console.error(
                        'Panel heartbeat gagal.',
                        error
                    );
                } finally {
                    heartbeatRunning = false;
                }
            };

            /**
             * Catat aktivitas pengguna.
             */
            const userActivity = () => {
                localStorage.setItem(
                    ACTIVITY_KEY,
                    Date.now().toString()
                );

                heartbeat();
            };

            /*
             * Login/page load dianggap aktivitas baru.
             */
            localStorage.setItem(
                ACTIVITY_KEY,
                Date.now().toString()
            );

            const events = [
                'pointerdown',
                'keydown',
                'touchstart',
                'scroll',
            ];

            events.forEach((eventName) => {
                window.addEventListener(
                    eventName,
                    userActivity, {
                        passive: true,
                    }
                );
            });

            /*
             * Cek setiap 30 detik.
             *
             * localStorage juga membuat aktivitas antar-tab
             * browser tetap sinkron.
             */
            window.setInterval(() => {
                const lastActivity = Number(
                    localStorage.getItem(ACTIVITY_KEY)
                );

                if (
                    lastActivity &&
                    Date.now() - lastActivity >= IDLE_TIMEOUT
                ) {
                    logout();
                }
            }, 30000);

            logoutButton?.addEventListener(
                'click',
                logout
            );
        })();
    </script>
    @stack('scripts')
</body>

</html>
