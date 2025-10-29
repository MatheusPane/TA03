@extends('layouts.layout')

@section('title', 'Edit Status Perkawinan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Status Perkawinan</h2>

    <form action="{{ route('ref_status_perkawinan.update', $ref_status_perkawinan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Status</label>
            <input type="text" name="nama" id="nama" class="form-control"
                   value="{{ old('nama', $ref_status_perkawinan->nama) }}" required>
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('ref_status_perkawinan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
