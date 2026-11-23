@extends('administrator.layouts.app')
@section('title', 'Form Pengumuman dan Pamflet')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Tambah Pengumuman dan Pamflet</span>
            </nav>
            <h1>Form Pengumuman dan Pamflet</h1>
            <p>Tambah pengumuman atau pamflet layanan.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.pamflet.index') }}">
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
            <span class="badge badge-draft">Baru</span>
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.pamflet.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="nm_pamflet">Judul Pengumuman/Pamflet<span class="required">*</span></label>
                            <input class="form-control @error('nm_pamflet') is-invalid @enderror" id="nm_pamflet"
                                name="nm_pamflet" type="text" value="{{ old('nm_pamflet') }}"
                                placeholder="Judul pengumuman">
                            @error('nm_pamflet')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="slug_pamflet">Slug Pengumuman/Pamflet</label>
                            <input class="form-control" id="slug_pamflet" type="text" value="{{ old('slug_pamflet') }}"
                                readonly placeholder="Slug dibuat otomatis">
                            <small>Slug dibuat otomatis berdasarkan judul.</small>
                        </div>

                        <div class="form-group full">
                            <label for="deskripsi">Isi Pengumuman<span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi"
                                placeholder="Tulis isi konten secara jelas dan informatif...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Gambar Pamflet<span class="required">*</span></label>
                            <label class="upload-box">
                                <input type="file" id="gambar" name="gambar[]" accept=".jpg,.jpeg,image/jpeg" multiple>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau pilih beberapa gambar</strong>
                                    <span>Hanya JPG/JPEG, Maksimal 5 MB per gambar.</span>
                                </span>
                            </label>

                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror


                            @foreach ($errors->get('gambar.*') as $messages)
                                @foreach ($messages as $message)
                                    <small class="text-danger" style="display:block;">{{ $message }}</small>
                                @endforeach
                            @endforeach

                            {{-- Preview gambar --}}
                            <div id="image-preview-grid"
                                style="
                                                                                                                                    display:grid;
                                                                                                                                    grid-template-columns:
                                                                                                                                    repeat(auto-fill, minmax(130px, 1fr));
                                                                                                                                    gap:12px;
                                                                                                                                    margin-top:15px;
                                                                                                                                ">
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Jejak perubahan --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak perubahan
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" readonly type="text"
                                value="{{ Auth::user()->name }}">
                        </div>

                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" readonly type="text"
                                value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                </div>


                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.pamflet.index') }}">
                        Batal
                    </a>
                    <button class="btn btn-primary" id="submitButton" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span id="submitText">Simpan data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Generate preview slug
            |--------------------------------------------------------------------------
            */

            const namaPamflet = document.getElementById('nm_pamflet');
            const slugPamflet = document.getElementById('slug_pamflet');

            function generateSlug(text) {

                return text
                    .toString()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            if (namaPamflet && slugPamflet) {

                slugPamflet.value = generateSlug(
                    namaPamflet.value
                );

                namaPamflet.addEventListener(
                    'input',
                    function () {

                        slugPamflet.value =
                            generateSlug(this.value);

                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Multiple image preview
            |--------------------------------------------------------------------------
            */

            const inputGambar =
                document.getElementById('gambar');

            const previewGrid =
                document.getElementById(
                    'image-preview-grid'
                );

            if (inputGambar && previewGrid) {

                inputGambar.addEventListener(
                    'change',
                    function () {

                        previewGrid.innerHTML = '';

                        const files =
                            Array.from(this.files);

                        files.forEach(function (file) {

                            const card =
                                document.createElement('div');

                            card.style.border =
                                '1px solid #ddd';

                            card.style.borderRadius =
                                '8px';

                            card.style.padding =
                                '8px';

                            card.style.background =
                                '#fff';


                            const image =
                                document.createElement('img');

                            image.style.width =
                                '100%';

                            image.style.height =
                                '120px';

                            image.style.objectFit =
                                'cover';

                            image.style.borderRadius =
                                '6px';


                            const url =
                                URL.createObjectURL(file);

                            image.src = url;

                            image.onload = function () {
                                URL.revokeObjectURL(url);
                            };


                            const name =
                                document.createElement('small');

                            name.style.display =
                                'block';

                            name.style.marginTop =
                                '6px';

                            name.style.wordBreak =
                                'break-word';

                            name.textContent =
                                file.name;


                            card.appendChild(image);
                            card.appendChild(name);

                            previewGrid.appendChild(card);

                        });

                    }
                );

            }

        });
    </script>

@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: '#deskripsi',
            menubar: false,
            plugins: [
                'advlist',
                'autolink',
                'lists',
                'preview',
                'anchor',
                'searchreplace',
                'visualblocks',
                'fullscreen',
                'wordcount',
                'fontfamily',
            ],

            toolbar:
                'undo redo | blocks | ' +
                'bold italic underline | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist | ' +
                'fontfamily | ' +
                'link image media table | ' +
                'code fullscreen',

            font_family_formats:
                'Plus Jakarta Sans=Plus Jakarta Sans,sans-serif;' +
                'Arial=Arial,Helvetica,sans-serif;' +
                'Times New Roman=Times New Roman,Times,serif;' +
                'Georgia=Georgia,serif;' +
                'Roboto=Roboto,sans-serif;' +
                'Poppins=Poppins,sans-serif;',

            content_css:
                'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
            content_style: `
                    html, body {
                        font-family: 'Plus Jakarta Sans', sans-serif !important;
                    }
                `,

            height: 500
        });
    </script>
@endpush