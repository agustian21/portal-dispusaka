@extends('administrator.layouts.app')
@section('title', 'Edit Pengumuman dan Pamflet')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Informasi</span><span>/</span>
                <span aria-current="page">Edit Pengumuman dan Pamflet</span>
            </nav>
            <h1>Edit Pengumuman dan Pamflet</h1>
            <p>Perbarui informasi pengumuman atau pamflet.</p>
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
                <p>Perbarui data pamflet sesuai kebutuhan.</p>
            </div>

            @if ($pamflet->status_id == 1)
                <span class="badge badge-success">Aktif</span>
            @else
                <span class="badge badge-draft">Tidak Aktif</span>
            @endif

        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.pamflet.update', $pamflet->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>Data konten
                    </div>

                    <div class="form-grid">

                        <div class="form-group full">
                            <label for="nm_pamflet">Judul Pengumuman/Pamflet<span class="required">*</span></label>
                            <input class="form-control @error('nm_pamflet') is-invalid @enderror" id="nm_pamflet"
                                name="nm_pamflet" type="text" value="{{ old('nm_pamflet', $pamflet->nm_pamflet) }}"
                                placeholder="Judul pengumuman">
                            @error('nm_pamflet')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="slug_pamflet">Slug Pengumuman/Pamflet</label>
                            <input class="form-control" id="slug_pamflet" type="text"
                                value="{{ old('slug_pamflet', $pamflet->slug_pamflet) }}" readonly>
                            <small>Slug otomatis mengikuti judul.</small>
                        </div>


                        {{-- Deskripsi --}}
                        <div class="form-group full">
                            <label for="deskripsi">Isi Pengumuman<span class="required">*</span></label>
                            <textarea class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                placeholder="Tulis isi konten...">{{ old('deskripsi', $pamflet->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Gambar Saat Ini</label>

                            @if (!empty($pamflet->gambar))

                                <div
                                    style="
                                        display:grid;
                                        grid-template-columns:
                                        repeat(auto-fill, minmax(160px, 1fr));
                                        gap:15px;
                                        margin-top:10px;
                                    ">

                                    @foreach ($pamflet->gambar as $gambar)
                                        <div
                                            style="
                                                border:1px solid #ddd;
                                                border-radius:10px;
                                                padding:10px;
                                                background:#fff;
                                            ">

                                            <img src="{{ asset('uploads_files/pamflet/' . $gambar) }}"
                                                alt="Gambar {{ $pamflet->nm_pamflet }}"
                                                style="
                                                    width:100%;
                                                    height:150px;
                                                    object-fit:cover;
                                                    border-radius:8px;
                                                ">


                                            <label
                                                style="
                                                    display:flex;
                                                    align-items:center;
                                                    gap:7px;
                                                    margin-top:10px;
                                                    cursor:pointer;
                                                ">

                                                <input type="checkbox" name="hapus_gambar[]" value="{{ $gambar }}"
                                                    @checked(in_array($gambar, old('hapus_gambar', [])))>

                                                <span>Hapus gambar</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <p>Tidak ada gambar tersimpan.</p>
                            @endif
                        </div>

                        <div class="form-group full">
                            <label>Tambah Gambar Baru</label>
                            <label class="upload-box">
                                <input type="file" id="gambar" name="gambar[]" accept=".jpg,.jpeg,image/jpeg"
                                    multiple>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik untuk menambahkan gambar</strong>
                                    <span>Hanya JPG/JPEG,Maksimal 5 MB per gambar.</span>
                                </span>
                            </label>
                            <small>Kosongkan jika tidak ingin menambah gambar.</small>

                            @error('gambar')
                                <small class="text-danger" style="display:block;">{{ $message }}</small>
                            @enderror

                            @foreach ($errors->get('gambar.*') as $messages)
                                @foreach ($messages as $message)
                                    <small class="text-danger" style="display:block;">{{ $message }}</small>
                                @endforeach
                            @endforeach

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

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak perubahan
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Dibuat Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ $pamflet->created_by }}">
                        </div>

                        <div class="form-group">
                            <label>Terakhir Diubah Oleh</label>
                            <input class="form-control" readonly type="text" value="{{ $pamflet->updated_by }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.pamflet.edit', $pamflet->id) }}">
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
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                /*
                |--------------------------------------------------------------------------
                | Slug preview
                |--------------------------------------------------------------------------
                */

                const namaPamflet =
                    document.getElementById(
                        'nm_pamflet'
                    );

                const slugPamflet =
                    document.getElementById(
                        'slug_pamflet'
                    );


                function generateSlug(text) {

                    return text
                        .toString()
                        .normalize('NFD')
                        .replace(
                            /[\u0300-\u036f]/g,
                            ''
                        )
                        .toLowerCase()
                        .trim()
                        .replace(
                            /[^a-z0-9]+/g,
                            '-'
                        )
                        .replace(
                            /^-+|-+$/g,
                            ''
                        );
                }


                if (
                    namaPamflet &&
                    slugPamflet
                ) {

                    namaPamflet.addEventListener(
                        'input',
                        function() {

                            slugPamflet.value =
                                generateSlug(
                                    this.value
                                );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Preview gambar baru
                |--------------------------------------------------------------------------
                */

                const inputGambar =
                    document.getElementById(
                        'gambar'
                    );


                const previewGrid =
                    document.getElementById(
                        'image-preview-grid'
                    );


                if (
                    inputGambar &&
                    previewGrid
                ) {

                    inputGambar.addEventListener(
                        'change',
                        function() {

                            previewGrid.innerHTML = '';

                            const files =
                                Array.from(
                                    this.files
                                );


                            files.forEach(
                                function(file) {

                                    const card =
                                        document.createElement(
                                            'div'
                                        );


                                    card.style.border =
                                        '1px solid #ddd';

                                    card.style.borderRadius =
                                        '8px';

                                    card.style.padding =
                                        '8px';

                                    card.style.background =
                                        '#fff';


                                    const image =
                                        document.createElement(
                                            'img'
                                        );


                                    image.style.width =
                                        '100%';

                                    image.style.height =
                                        '120px';

                                    image.style.objectFit =
                                        'cover';

                                    image.style.borderRadius =
                                        '6px';


                                    const url =
                                        URL.createObjectURL(
                                            file
                                        );


                                    image.src = url;


                                    image.onload =
                                        function() {

                                            URL.revokeObjectURL(
                                                url
                                            );

                                        };


                                    const name =
                                        document.createElement(
                                            'small'
                                        );


                                    name.style.display =
                                        'block';

                                    name.style.marginTop =
                                        '6px';

                                    name.style.wordBreak =
                                        'break-word';

                                    name.textContent =
                                        file.name;


                                    card.appendChild(
                                        image
                                    );

                                    card.appendChild(
                                        name
                                    );

                                    previewGrid.appendChild(
                                        card
                                    );

                                }
                            );

                        }
                    );

                }

            }
        );
    </script>

@endsection
