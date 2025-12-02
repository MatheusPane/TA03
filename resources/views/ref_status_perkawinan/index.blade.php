@extends('layouts.layout')

@section('title', 'Status Perkawinan')

@section('content')
<div class="app-main">
    <main class="app-content">
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <h1 class="app-content-header-title">Status Perkawinan</h1>
            <a href="{{ route('ref_status_perkawinan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Status
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
                                <th>Nama Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($statusList as $index => $status)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $status->nama }}</td>
                                    <td>
                                        <a href="{{ route('ref_status_perkawinan.edit', $status->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> 
                                        </a>
                                        <form action="{{ route('ref_status_perkawinan.destroy', $status->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="3" class="text-center text-muted">Belum ada data</td>
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
