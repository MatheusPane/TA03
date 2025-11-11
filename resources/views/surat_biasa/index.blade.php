{{-- resources/views/surat_biasa/index.blade.php --}}
@extends('layouts.layout')

@section('title', 'Daftar Surat Biasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">
                Daftar Surat Biasa
            </h4>
            <a href="{{ route('surat-biasa.create') }}" class="btn btn-primary btn-sm">
                Buat Surat Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Kepada</th>
                        <th>Tanggal</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat as $i => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nomor }}</strong></td>
                        <td>{{ $item->perihal }}</td>
                        <td>{{ $item->kepada }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>{{ $item->jabatan?->nama ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('surat-biasa.show', $item) }}" class="btn btn-info btn-sm" title="Lihat">
                                Lihat
                            </a>
                            <a href="{{ route('surat-biasa.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                Edit
                            </a>
                            <a href="{{ route('surat-biasa.cetak', $item) }}" target="_blank" class="btn btn-success btn-sm" title="Cetak">
                                Cetak
                            </a>
                            <form action="{{ route('surat-biasa.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Yakin arsipkan surat ini?')">
                                    Arsip
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada surat biasa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection