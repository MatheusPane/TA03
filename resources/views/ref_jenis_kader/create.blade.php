@extends('layouts.layout')

@section('title', 'Tambah Jenis Kader')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Tambah Jenis Kader</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('ref-jenis-kader.store') }}" method="POST">
            @csrf
        
            <div class="mb-3">
                <label class="form-label">Kegiatan</label>
                <select name="ref_kegiatan_warga_id" class="form-select" required>
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach($kegiatan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label class="form-label">Nama Jenis Kader</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
        
            <button class="btn btn-primary">Simpan</button>
        </form>
        
    </div>
</div>
@endsection
