@extends('layouts.layout')

@section('title', 'Referensi Jabatan')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Referensi Jabatan</h4>

    <a href="{{ route('ref_jabatan.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Tambah Jabatan
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Dibuat Oleh</th>
                <th>Diperbarui Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jabatanList as $key => $jabatan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $jabatan->nama }}</td>
                    <td>{{ $jabatan->created_by }}</td>
                    <td>{{ $jabatan->updated_by }}</td>
                    <td>
                        <a href="{{ route('ref_jabatan.edit', $jabatan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('ref_jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
