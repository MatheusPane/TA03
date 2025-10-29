@extends('layouts.layout')
@section('title', 'Tambah Keluarga')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Status Dalam Keluarga</h1>

    <a href="{{ route('ref_status_dalam_keluarga.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah --}}
    <form action="{{ route('ref_status_dalam_keluarga.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Status Dalam Keluarga</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Kepala Keluarga" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('ref_status_dalam_keluarga.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
