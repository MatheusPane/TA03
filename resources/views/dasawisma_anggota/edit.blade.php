@extends('layouts.layout')
@section('title', 'Edit Peran Anggota')

@section('content')
<div class="container mt-4">
    <h4>Edit Peran: {{ $anggota->warga->nama }}</h4>
    <p><strong>Dasawisma:</strong> {{ $anggota->dasawisma->nama }}</p>

    <form action="{{ route('dasawisma_anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Peran Saat Ini</label>
            <select name="peran" class="form-select" required>
                <option value="anggota" {{ $anggota->peran == 'anggota' ? 'selected' : '' }}>Anggota</option>
                <option value="wakil ketua" {{ $anggota->peran == 'wakil ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                <option value="sekretaris" {{ $anggota->peran == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="bendahara" {{ $anggota->peran == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('dasawisma_anggota.index', $anggota->dasawisma_id) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection