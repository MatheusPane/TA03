@extends('layouts.layout')

@section('title', 'Kelola Pendidikan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Kelola Pendidikan</h1>
            <a href="{{ route('ref_pendidikan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pendidikan
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
                                <th width="5%">#</th>
                                <th>Nama Pendidikan</th>
                                <th>Dibuat Oleh</th>
                                <th>Diperbarui Oleh</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendidikanList as $index => $pendidikan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pendidikan->nama }}</td>
                                    <td>{{ $pendidikan->creator->name ?? '-' }}</td>
                                    <td>{{ $pendidikan->updater->name ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('ref_pendidikan.edit', $pendidikan->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> 
                                        </a>
                                        <form action="{{ route('ref_pendidikan.destroy', $pendidikan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data Pendidikan</td>
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
