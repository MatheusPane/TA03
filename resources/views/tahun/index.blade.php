@extends('layouts.layout')

@section('title', 'Tahun Pemerintahan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Tahun Pemerintahan</h1>
            <a href="{{ route('tahun.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Tahun
            </a>
        </div>

        <div class="app-content-body mt-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Tahun</th>
                                <th>Nama</th>
                                <th>Aktif</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tahunList as $index => $tahun)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tahun->tahun }}</td>
                                    <td>{{ $tahun->nama ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $tahun->active ? 'success' : 'secondary' }}">
                                            {{ $tahun->active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('tahun.edit', $tahun->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('tahun.destroy', $tahun->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
