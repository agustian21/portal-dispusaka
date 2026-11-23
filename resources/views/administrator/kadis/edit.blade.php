@extends('administrator.layouts.app')
@section('title', 'Edit Profil Pejabat')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>Profil Dinas</span><span>/</span>
                <span aria-current="page">Edit Profil Pejabat</span>
            </nav>

            <h1>Edit Profil Pejabat</h1>
            <p>Perbarui data pejabat yang dipilih.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.data-kadis.index') }}">
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

            @if ($kadis->status_id == 1)
                <span class="badge badge-active">Aktif</span>
            @else
                <span class="badge badge-draft">Nonaktif</span>
            @endif
        </div>

        <div class="card-body">
            <form id="pamfletForm" action="{{ route('panel.data-kadis.update', $kadis->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        Data konten
                    </div>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="foto">Foto</label>
                            <label class="upload-box">
                                <input type="file" id="foto" name="foto"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-upload>
                                <span class="upload-copy">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    <strong>Klik atau letakkan berkas di sini</strong>
                                    <span>JPG, JPEG atau PNG. Maksimal 3 MB.Kosongkan jika tidak ingin mengganti
                                        foto.</span>
                                </span>
                                <img class="upload-preview" alt="Pratinjau unggahan">
                            </label>
                            <small class="text-danger">Kosongkan jika tidak ingin mengubah foto.</small>
                            @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label>Gambar Saat Ini</label>

                            @if (!empty($kadis->foto))
                                <div
                                    style="
                                        display:grid;
                                        grid-template-columns:
                                        repeat(auto-fill, minmax(160px, 1fr));
                                        gap:15px;
                                        margin-top:10px;
                                    ">

                                    <div
                                        style="
                                                border:1px solid #ddd;
                                                border-radius:10px;
                                                padding:10px;
                                                background:#fff;
                                            ">

                                        <img src="{{ asset('uploads_files/kadis/' . $kadis->foto) }}"
                                            alt="Gambar {{ $kadis->nama }}"
                                            style="
                                                    width:100%;
                                                    height:180px;
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
                                        </label>
                                    </div>

                                </div>
                            @else
                                <p>Tidak ada gambar tersimpan.</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Pejabat<span class="required">*</span></label>
                            <input class="form-control" id="nama" name="nama" required type="text"
                                value="{{ old('nama', $kadis->nama) }}" placeholder="Nama lengkap dan gelar"
                                autocomplete="off">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="periode">Periode <span class="required">*</span></label>
                            <input class="form-control" id="periode" name="periode" type="text"
                                value="{{ old('periode', $kadis->periode) }}" placeholder="Masukkan periode kepala dinas"
                                autocomplete="off">
                            @error('periode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="jabatan">Jabatan <span class="required">*</span></label>
                            <input class="form-control" id="jabatan" name="jabatan" type="text"
                                value="{{ old('jabatan', $kadis->jabatan) }}" placeholder="Masukkan jabatan kepala dinas"
                                autocomplete="off">
                            @error('jabatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- JEJAK PERUBAHAN --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>
                        Jejak perubahan
                    </div>

                    <div class="form-grid">

                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" readonly type="text"
                                value="{{ $kadis->created_by ?? '-' }}">
                        </div>

                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" readonly type="text"
                                value="{{ auth()->user()->name }}">
                        </div>

                    </div>
                </div>


                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.data-kadis.edit', $kadis->id) }}">
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
@endsection
