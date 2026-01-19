@extends('layouts.layout')

@section('title', 'Tambah Kader')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Tambah Data Kader</h5>
    </div>

<div class="card-body">
    <form method="POST" action="{{ route('kader.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Warga</label>
            <select name="warga_id" class="form-control" required>
                <option value="">-- Pilih Warga --</option>
                @foreach($warga as $w)
                    <option value="{{ $w->id }}">
                        {{ $w->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Dusun</label>
            <select name="dusun_id" class="form-control" required>
                <option value="">-- Pilih Dusun --</option>
                @foreach($dusun as $d)
                    <option value="{{ $d->id }}">
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kader</label>
            <select name="ref_jenis_kader_id" class="form-control" required>
                <option value="">-- Pilih Jenis Kader --</option>
                @foreach($jenisKader as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->kegiatan->nama }} - {{ $j->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number"
                   name="tahun"
                   class="form-control"
                   value="{{ date('Y') }}"
                   required>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('kader.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

</div>
@endsection
