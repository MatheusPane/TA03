@extends('layouts.layout')

@section('title', 'Edit Kader')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Edit Data Kader</h5>
    </div>

<div class="card-body">
    <form method="POST"
          action="{{ route('kader.update', $kader->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Warga</label>
            <select name="warga_id" class="form-control" required>
                @foreach($warga as $w)
                    <option value="{{ $w->id }}"
                        {{ $kader->warga_id == $w->id ? 'selected' : '' }}>
                        {{ $w->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Dusun</label>
            <select name="dusun_id" class="form-control" required>
                @foreach($dusun as $d)
                    <option value="{{ $d->id }}"
                        {{ $kader->dusun_id == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kader</label>
            <select name="ref_jenis_kader_id" class="form-control" required>
                @foreach($jenisKader as $j)
                    <option value="{{ $j->id }}"
                        {{ $kader->ref_jenis_kader_id == $j->id ? 'selected' : '' }}>
                        {{ $j->kegiatan->nama }} - {{ $j->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number"
                   name="tahun"
                   value="{{ $kader->tahun }}"
                   class="form-control"
                   required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('kader.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>


</div>
@endsection
