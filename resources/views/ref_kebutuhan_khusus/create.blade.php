@extends('layouts.layout')
@section('title', 'Tambah Kebutuhan')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Kebutuhan Khusus</h1>

    <a href="{{ route('ref_kebutuhan_khusus.index') }}" class="btn btn-secondary mb-3">
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
    <form action="{{ route('ref_kebutuhan_khusus.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kebutuhan Khusus</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Tunanetra" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('ref_kebutuhan_khusus.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
