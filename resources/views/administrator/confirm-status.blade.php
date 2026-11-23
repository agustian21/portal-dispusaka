@extends('administrator.layouts.app')
@section('title', 'Konfirmasi Perubahan Status')

@section('contents')
    <div class="page-head">
        <div>
            <h1>Konfirmasi Perubahan Status</h1>
            <p>Pastikan Anda ingin mengubah status data ini.</p>
        </div>
    </div>

    <section class="card form-card">
        <div class="card-body">
            <p>Apakah Anda yakin ingin mengubah status <strong>{{ $dataLabel }}</strong>?</p>
            <p>Perubahan hanya diproses setelah tombol konfirmasi ditekan.</p>

            <form method="POST" action="{{ $formAction }}">
                @csrf
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ya, Ubah Status</button>
                    <a class="btn" href="{{ url()->previous() }}">Batal</a>
                </div>
            </form>
        </div>
    </section>
@endsection
