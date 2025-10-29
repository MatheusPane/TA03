@extends('layouts.layout')

@section('title', 'Tambah Tahun Pemerintahan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Tambah Tahun Pemerintahan</h1>
            <a href="{{ route('tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tahun.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" id="tahun" 
                                   value="{{ old('tahun') }}" 
                                   class="form-control @error('tahun') is-invalid @enderror" 
                                   required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" 
                                   value="{{ old('nama') }}" 
                                   class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('tahun.index') }}" class="btn btn-light border">
                            Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
