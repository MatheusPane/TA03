@extends('layouts.layout')

@section('title', 'Edit Data Keluarga')

@section('content')
<div class="container mt-4">
    <h4>Edit Data Keluarga</h4>

    <form action="{{ route('data_keluarga.update', $keluarga->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">No KK</label>
                <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $keluarga->no_kk) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dusun</label>
                <select name="dusun_id" class="form-select">
                    <option value="">-- Pilih Dusun --</option>
                    @foreach($dusun as $d)
                        <option value="{{ $d->id }}" {{ old('dusun_id', $keluarga->dusun_id) == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('data_keluarga.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
