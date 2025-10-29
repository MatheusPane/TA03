@extends('layouts.layout')

@section('title', 'Edit Jenis Kelompok Belajar')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header">
            <h1 class="app-content-header-title">Edit Jenis Kelompok Belajar</h1>
            <a href="{{ route('ref_jenis_kelompok_belajar.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ref_jenis_kelompok_belajar.update', $ref_jenis_kelompok_belajar->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kelompok Belajar</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $ref_jenis_kelompok_belajar->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Perbarui
                        </button>
                        <a href="{{ route('ref_jenis_kelompok_belajar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
