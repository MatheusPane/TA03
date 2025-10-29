@extends('layouts.layout')
@section('title', 'Referensi Status Dalam Keluarga')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Referensi Status Dalam Keluarga</h1>

    {{-- ✅ Alert Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Tombol Tambah (Hanya Admin) --}}
    @if (auth()->user()->hasRole('Admin'))
        <a href="{{ route('ref_status_dalam_keluarga.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Status Dalam Keluarga
        </a>
    @endif

    {{-- ✅ Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama</th>
                    <th style="width: 8%">Aktif</th>
                    <th>Dibuat Oleh</th>
                    <th>Diperbarui Oleh</th>
                    @if(auth()->user()->hasRole('Admin'))
                        <th style="width: 15%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->active ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td>{{ $item->createdBy->name ?? '-' }}</td>
                        <td>{{ $item->updatedBy->name ?? '-' }}</td>

                        @if(auth()->user()->hasRole('Admin'))
                            <td class="text-center">
                                {{-- Tombol Edit --}}
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('ref_status_dalam_keluarga.destroy', $item->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                         aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('ref_status_dalam_keluarga.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                            Edit Status Dalam Keluarga
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama{{ $item->id }}" class="form-label">Nama Status</label>
                                            <input type="text" name="nama" id="nama{{ $item->id }}"
                                                   class="form-control" value="{{ $item->nama }}" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data status dalam keluarga.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
