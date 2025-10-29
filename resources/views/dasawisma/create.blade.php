@extends('layouts.layout')
@section('title', 'Tambah Dasawisma')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Dasawisma</h1>

    {{-- Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dasawisma.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Dasawisma</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dusun_id" class="form-label">Dusun</label>
            <select name="dusun_id" id="dusun_id" class="form-select">
                <option value="">-- Pilih Dusun --</option>
                @foreach($dusun as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ketua_warga_id" class="form-label">Ketua Dasawisma</label>
            <select name="ketua_warga_id" id="ketua_warga_id" class="form-select">
                <option value="">-- Pilih Warga --</option>
                @foreach($warga as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('dasawisma.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
