@extends('layouts.layout')

@section('title', 'Tambah Pekerjaan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header">
            <h1 class="app-content-header-title">Tambah Pekerjaan</h1>
            <a href="{{ route('ref_pekerjaan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ref_pekerjaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pekerjaan</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('ref_pekerjaan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
