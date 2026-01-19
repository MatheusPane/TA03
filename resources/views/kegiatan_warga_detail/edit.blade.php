@extends('layouts.layout')

@section('title', 'Edit Sub Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Sub Kegiatan</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('kegiatan-warga-detail.update', $kegiatanWarga->id) }}">
            @csrf
            @method('PUT')

            <p>
                <strong>Warga:</strong> {{ $kegiatanWarga->warga->nama }} <br>
                <strong>Kegiatan:</strong> {{ $kegiatanWarga->refKegiatan->nama }}
            </p>

            @foreach($jenisKader as $j)
                <div class="form-check">
                    <input type="checkbox"
                           name="ref_jenis_kader_id[]"
                           value="{{ $j->id }}"
                           class="form-check-input"
                           {{ in_array($j->id, $selected) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $j->kegiatan->nama }} - {{ $j->nama }}
                    </label>
                </div>
            @endforeach

            <button class="btn btn-primary mt-3">Update</button>
            <a href="{{ route('kegiatan-warga-detail.index') }}"
               class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
</div>
@endsection
