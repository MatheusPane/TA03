@extends('layouts.layout')

@section('title', 'Edit Pekerjaan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header">
            <h1 class="app-content-header-title">Edit Pekerjaan</h1>
            <a href="{{ route('ref_pekerjaan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ref_pekerjaan.update', $ref_pekerjaan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pekerjaan</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $ref_pekerjaan->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Perbarui
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
