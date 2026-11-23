@extends('administrator.layouts.app')
@section('title', 'Form Slider Website')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a>
                <span>/</span>
                <span>Informasi</span>
                <span>/</span>
                <span aria-current="page">Form Slider Website</span>
            </nav>

            <h1>Form Slider Website</h1>
            <p>Tambah data slider website.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.slider-website.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Kembali
            </a>
        </div>
    </div>

    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Kolom bertanda bintang wajib diisi.</p>
            </div>

            <span class="badge badge-active">Aktif</span>
        </div>

        <div class="card-body">

            <form id="pamfletForm" action="{{ route('panel.slider-website.store') }}" method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>Data Konten
                    </div>

                    <div class="form-grid">

                        <div class="form-group full">
                            <label for="gambar">Gambar Slider<span class="required">*</span></label>
                            <label class="upload-box">
                                <input type="file" id="gambar" name="gambar"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau letakkan berkas di sini</strong>
                                    <span>
                                        JPG, JPEG, atau PNG.
                                        Maksimal 1 MB.
                                        Dimensi wajib 1180 × 590 px.
                                    </span>
                                </span>
                                <img id="gambarPreview" class="upload-preview" alt="Pratinjau gambar slider">
                            </label>
                            <span class="text-danger">
                                JPG, JPEG, atau PNG.
                                Maksimal 1 MB.
                                Dimensi gambar wajib 1180 × 590 px.
                            </span>

                            <small id="gambarClientError" class="text-danger"></small>
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="nm_slide">Judul Slider<span class="required">*</span></label>
                            <input class="form-control" id="nm_slide" name="nm_slide" type="text" maxlength="255"
                                value="{{ old('nm_slide') }}" placeholder="Masukkan judul slider" autocomplete="off">
                            @error('nm_slide')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak Perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Dibuat Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ auth()->user()->name }}">
                        </div>

                        <div class="form-group">
                            <label>Diubah Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ auth()->user()->name }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.slider-website.create') }}">
                        Batal
                    </a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('sliderForm');
            const input = document.getElementById('gambar');
            const preview = document.getElementById('gambarPreview');
            const error = document.getElementById('gambarClientError');

            let gambarValid = false;

            const MAX_SIZE = 1024 * 1024;
            const REQUIRED_WIDTH = 1180;
            const REQUIRED_HEIGHT = 590;

            const allowedTypes = [
                'image/jpeg',
                'image/png'
            ];

            function resetGambar(message = '') {
                gambarValid = false;

                error.textContent = message;

                if (message) {
                    input.value = '';
                    preview.removeAttribute('src');
                    preview.style.display = 'none';
                }
            }

            input.addEventListener('change', function() {

                error.textContent = '';
                gambarValid = false;

                const file = this.files[0];

                if (!file) {
                    resetGambar();
                    return;
                }

                /*
                 * Validasi tipe file.
                 */
                if (!allowedTypes.includes(file.type)) {
                    resetGambar(
                        'Gambar hanya boleh berformat JPG, JPEG, atau PNG.'
                    );
                    return;
                }

                /*
                 * Validasi maksimal 1 MB.
                 */
                if (file.size > MAX_SIZE) {
                    resetGambar(
                        'Ukuran gambar maksimal 1 MB.'
                    );
                    return;
                }

                /*
                 * Validasi dimensi gambar.
                 */
                const image = new Image();
                const objectUrl = URL.createObjectURL(file);

                image.onload = function() {

                    if (
                        image.width !== REQUIRED_WIDTH ||
                        image.height !== REQUIRED_HEIGHT
                    ) {
                        URL.revokeObjectURL(objectUrl);

                        resetGambar(
                            `Dimensi gambar harus tepat ${REQUIRED_WIDTH} × ${REQUIRED_HEIGHT} px. ` +
                            `Gambar yang dipilih berukuran ${image.width} × ${image.height} px.`
                        );

                        return;
                    }

                    gambarValid = true;

                    preview.src = objectUrl;
                    preview.style.display = 'block';
                };

                image.onerror = function() {

                    URL.revokeObjectURL(objectUrl);

                    resetGambar(
                        'File gambar tidak dapat dibaca.'
                    );
                };
            });

            form.addEventListener('submit', function(event) {

                if (!input.files.length) {
                    event.preventDefault();

                    error.textContent =
                        'Gambar slider wajib diunggah.';

                    return;
                }

                if (!gambarValid) {
                    event.preventDefault();

                    error.textContent =
                        'Pastikan gambar sudah memenuhi ukuran dan dimensi yang ditentukan.';
                }
            });
        });
    </script>
@endsection
