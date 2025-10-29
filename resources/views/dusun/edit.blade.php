@extends('layouts.layout')

@section('title', 'Edit Dusun')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Edit Dusun</h1>
            <a href="{{ route('dusun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Dusun</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama', $dusun->nama) }}" required>
                            @error('nama')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_konfigurasi_id" class="form-label">Tahun Konfigurasi</label>
                            <select name="tahun_konfigurasi_id" id="tahun_konfigurasi_id" class="form-select" required>
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($tahunList as $tahun)
                                    <option value="{{ $tahun->id }}" {{ $dusun->tahun_konfigurasi_id == $tahun->id ? 'selected' : '' }}>
                                        {{ $tahun->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_konfigurasi_id')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Perbarui
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
