@extends('layouts.layout')

@section('title', 'Referensi Kegiatan Warga')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Referensi Kegiatan Warga
            </h4>
            <a href="{{ route('ref_kegiatan_warga.create') }}" class="btn btn-light" style="border-radius: 10px;">
                Tambah Kegiatan
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert" style="border-radius: 10px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert" style="border-radius: 10px;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="80" class="text-center">No</th>
                            <th>Kegiatan</th>
                            <th width="80" class="text-center">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatanList as $key => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $item->active ? 'success' : 'secondary' }}">
                                    {{ $item->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ref_kegiatan_warga.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('ref_kegiatan_warga.destroy', $item->id) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data kegiatan warga.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection