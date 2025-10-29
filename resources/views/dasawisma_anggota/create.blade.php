@extends('layouts.layout')
@section('title', 'Tambah Anggota Dasawisma')

@section('content')
<div class="container mt-4">
    <h4>Tambah Anggota ke: <strong>{{ $dasawisma->nama }}</strong></h4>

    <form action="{{ route('dasawisma_anggota.store', $dasawisma->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Pilih Warga</label>
            <select name="warga_id" class="form-select" required>
                <option value="">-- Pilih Warga --</option>
                @foreach($warga as $w)
                    <option value="{{ $w->id }}">{{ $w->nama }} ({{ $w->nik }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Peran</label>
            <select name="peran" class="form-select" required>
                <option value="anggota">Anggota</option>
                <option value="wakil ketua">Wakil Ketua</option>
                <option value="sekretaris">Sekretaris</option>
                <option value="bendahara">Bendahara</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('dasawisma_anggota.index', $dasawisma->id) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection