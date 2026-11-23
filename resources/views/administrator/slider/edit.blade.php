@extends('administrator.layouts.app')
@section('title', 'Edit Slider Website')

@section('contents')

    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Edit Slider Website</span>
            </nav>
            <h1>Edit Slider Website</h1>
            <p>Perbarui data slider website.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.slider-website.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>Kembali
            </a>
        </div>
    </div>


    <section class="card form-card">
        <div class="card-head">
            <div>
                <h2>Informasi Utama</h2>
                <p>Perbarui informasi slider yang diperlukan.</p>
            </div>

            @if ($slider->status_id == 1)
                <span class="badge badge-active">
                    Aktif
                </span>
            @else
                <span class="badge badge-draft">
                    Tidak Aktif
                </span>
            @endif
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.slider-website.update', $slider->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        Data Konten
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Gambar Saat Ini</label>

                            @if (!empty($slider->gambar))
                                <div style="margin-top: 10px; width:100%; max-width:1180px;">
                                    <div
                                        style="
                                            border:1px solid #ddd;
                                        border-radius:10px;
                                        padding:10px;
                                        background:#fff;
                                    ">

                                        <img src="{{ asset('uploads_files/slider/' . $slider->gambar) }}"
                                            alt="Gambar {{ $slider->nm_slide }}"
                                            style="
                                            width:380px;
                                            max-width:100%;
                                            height:auto;
                                            border-radius:8px;
                                            display:block;
                                            ">
                                    </div>
                                </div>
                            @else
                                <p>Tidak ada gambar tersimpan.</p>
                            @endif
                        </div>

                        <div class="form-group full">
                            <label for="gambar">Gambar Slider</label>
                            <label class="upload-box">
                                <input type="file" id="gambar" name="gambar"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik untuk mengganti gambar</strong>
                                    <span>
                                        Kosongkan jika gambar tidak ingin diganti.
                                        JPG, JPEG, atau PNG.
                                        Maksimal 1 MB.
                                        Dimensi wajib 1180 × 590 px.
                                    </span>
                                </span>
                                <img id="gambarPreview" class="upload-preview" alt="Pratinjau gambar slider">
                            </label>
                            <span class="text-danger">
                                Kosongkan jika gambar tidak ingin diganti.
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
                                value="{{ old('nm_slide', $slider->nm_slide) }}" placeholder="Masukkan judul slider"
                                autocomplete="off" required>
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
                            <input class="form-control" readonly type="text" value="{{ $slider->created_by }}">
                        </div>

                        <div class="form-group">
                            <label>Diubah Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ auth()->user()->name }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.slider-website.edit', $slider->id) }}">
                        Batal
                    </a>

                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan Perubahan</span>
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

            let gambarBaruValid = true;

            const MAX_SIZE = 1024 * 1024;
            const REQUIRED_WIDTH = 1180;
            const REQUIRED_HEIGHT = 590;

            const allowedTypes = [
                'image/jpeg',
                'image/png'
            ];

            input.addEventListener('change', function() {

                const file = this.files[0];

                error.textContent = '';

                /*
                 * Tidak memilih gambar baru diperbolehkan.
                 */
                if (!file) {
                    gambarBaruValid = true;
                    return;
                }

                gambarBaruValid = false;


                if (!allowedTypes.includes(file.type)) {

                    error.textContent =
                        'Gambar hanya boleh berformat JPG, JPEG, atau PNG.';

                    input.value = '';

                    return;
                }


                if (file.size > MAX_SIZE) {

                    error.textContent =
                        'Ukuran gambar maksimal 1 MB.';

                    input.value = '';

                    return;
                }


                const image = new Image();
                const objectUrl = URL.createObjectURL(file);

                image.onload = function() {

                    if (
                        image.width !== REQUIRED_WIDTH ||
                        image.height !== REQUIRED_HEIGHT
                    ) {

                        error.textContent =
                            `Dimensi gambar harus tepat ${REQUIRED_WIDTH} × ${REQUIRED_HEIGHT} px. ` +
                            `Gambar yang dipilih berukuran ${image.width} × ${image.height} px.`;

                        input.value = '';

                        gambarBaruValid = false;

                        URL.revokeObjectURL(objectUrl);

                        return;
                    }

                    gambarBaruValid = true;

                    preview.src = objectUrl;
                    preview.style.display = 'block';
                };


                image.onerror = function() {

                    error.textContent =
                        'File gambar tidak dapat dibaca.';

                    input.value = '';

                    gambarBaruValid = false;

                    URL.revokeObjectURL(objectUrl);
                };
            });


            form.addEventListener('submit', function(event) {

                if (!gambarBaruValid) {

                    event.preventDefault();

                    error.textContent =
                        'Gambar baru belum memenuhi ketentuan upload.';
                }
            });

        });
    </script>

@endsection
