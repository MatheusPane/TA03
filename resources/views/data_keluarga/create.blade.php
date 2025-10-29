@extends('layouts.layout')

@section('title', 'Tambah Data Keluarga')

@section('content')
<div class="container mt-4">
    <h4>Tambah Data Keluarga</h4>

    <form action="{{ route('data_keluarga.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">No KK</label>
                <input type="text" name="no_kk" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dusun</label>
                <select name="dusun_id" class="form-select">
                    <option value="">-- Pilih Dusun --</option>
                    @foreach($dusun as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dasawisma</label>
                <select name="dasawisma_id" class="form-select">
                    <option value="">-- Pilih Dasawisma --</option>
                    @foreach($dasawisma as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('data_keluarga.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection