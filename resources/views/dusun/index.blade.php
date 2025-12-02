@extends('layouts.layout')

@section('title', 'Kelola Dusun')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Kelola Dusun</h1>
            <a href="{{ route('dusun.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Dusun
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
                                <th>Nama Dusun</th>
                                <th>Tahun Konfigurasi</th>
                                <th>Dibuat Oleh</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dusunList as $index => $dusun)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dusun->nama }}</td>
                                    <td>{{ $dusun->tahunKonfigurasi->nama ?? '-' }}</td>
                                    <td>{{ $dusun->created_by ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('dusun.edit', $dusun->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> 
                                        </a>
                                        <form action="{{ route('dusun.destroy', $dusun->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus dusun ini?')">
                                                <i class="bi bi-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data dusun</td>
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
