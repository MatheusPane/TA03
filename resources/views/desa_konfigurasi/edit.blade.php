@extends('layouts.layout')

@section('title', 'Edit Konfigurasi Desa')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header">
            <h1 class="app-content-header-title">Edit Konfigurasi Desa</h1>
        </div>

        <div class="app-content-body mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('desa-konfigurasi.update', $desaKonfigurasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="key" class="form-label">Key</label>
                            <input type="text" name="key" class="form-control" id="key" value="{{ old('key', $desaKonfigurasi->key) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <textarea name="value" class="form-control" id="value" rows="3">{{ old('value', $desaKonfigurasi->value) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('desa-konfigurasi.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
