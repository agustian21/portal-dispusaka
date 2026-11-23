```blade
@extends('administrator.layouts.app')
@section('title', 'Edit Informasi Publik')

@section('contents')
    <div class="page-head">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('panel.beranda') }}">Beranda</a><span>/</span>
                <span>PPID</span><span>/</span>
                <span aria-current="page">Edit Informasi Publik</span>
            </nav>

            <h1>Edit Informasi Publik</h1>
            <p>Perbarui data dokumen informasi publik.</p>
        </div>

        <div class="head-actions">
            <a class="btn btn-secondary" href="{{ route('panel.ppid.index') }}">
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

            @if ($ppid->status_id == 1)
                <span class="badge badge-active">Status : Aktif</span>
            @else
                <span class="badge badge-inactive">Status : Non-aktif</span>
            @endif
        </div>


        <div class="card-body">

            <form id="ppidForm" method="POST" action="{{ route('panel.ppid.update', $ppid->id) }}">
                @csrf
                @method('PUT')
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        Data Konten
                    </div>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="judul">Judul<span class="required">*</span></label>
                            <input class="form-control" id="judul" name="judul" type="text"
                                value="{{ old('judul', $ppid->judul) }}" placeholder="Judul dokumen" maxlength="255">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="katinformasi_id">Kategori Publik<span class="required">*</span></label>
                            <select class="form-control" id="katinformasi_id" name="katinformasi_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($katinformasi as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('katinformasi_id', $ppid->katinformasi_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_katinformasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('katinformasi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun<span class="required">*</span></label>
                            <input class="form-control" id="tahun" name="tahun" type="text"
                                value="{{ old('tahun', $ppid->tahun) }}" placeholder="Tahun dokumen">
                            @error('tahun')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="katppid_id">Informasi Publik<span class="required">*</span></label>
                            <select class="form-control" id="katppid_id" name="katppid_id" required>
                                <option value="">Pilih Informasi Publik</option>
                                @foreach ($katppid as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('katppid_id', $ppid->katppid_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nm_ppid }}
                                    </option>
                                @endforeach
                            </select>
                            @error('katppid_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="file">Link Google Drive<span class="required">*</span></label>
                            <input class="form-control" id="file" name="file" type="url"
                                value="{{ old('file', $ppid->file) }}" placeholder="https://drive.google.com/file/d/..."
                                autocomplete="off" required>
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if ($ppid->file)
                                <div style="margin-top:8px;">
                                    <a href="{{ $ppid->file }}" target="_blank" rel="noopener noreferrer"
                                        style="color:#155cc0;font-weight:600;">
                                        <i class="fa-brands fa-google-drive" aria-hidden="true"
                                            style="margin-right:6px;"></i>
                                        Buka dokumen saat ini
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user-pen" aria-hidden="true"></i>Jejak Perubahan
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="created_by">Dibuat Oleh</label>
                            <input class="form-control" id="created_by" type="text"
                                value="{{ $ppid->created_by ?? '-' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="updated_by">Diubah Oleh</label>
                            <input class="form-control" id="updated_by" type="text" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary" href="{{ route('panel.ppid.index') }}">
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
