@extends('layouts.layout')

@section('title', 'Kelola Konfigurasi Desa')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header">
            <h1 class="app-content-header-title">Konfigurasi Desa</h1>
            <a href="{{ route('desa-konfigurasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Konfigurasi
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
                                <th>Key</th>
                                <th>Value</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($configs as $index => $config)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $config->key }}</td>
                                    <td>{{ $config->value ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('desa-konfigurasi.edit', $config->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> 
                                        </a>
                                        <form action="{{ route('desa-konfigurasi.destroy', $config->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus konfigurasi ini?')">
                                                <i class="bi bi-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada konfigurasi</td>
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
