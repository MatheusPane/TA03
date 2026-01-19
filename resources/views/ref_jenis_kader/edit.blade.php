@extends('layouts.layout')

@section('title', 'Edit Jenis Kader')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Jenis Kader</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('ref-jenis-kader.update', $jenisKader->id) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kegiatan</label>
                <select name="ref_kegiatan_id" class="form-control">
                    @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}"
                            {{ $jenisKader->ref_kegiatan_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Jenis Kader</label>
                <input type="text" name="nama"
                       value="{{ $jenisKader->nama }}"
                       class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('ref-jenis-kader.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
