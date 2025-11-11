@extends('layouts.layout')

@section('title', 'Referensi Sumber Air')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Referensi Sumber Air
            </h4>
            <a href="{{ route('ref_sumber_air.create') }}" class="btn btn-light" style="border-radius: 10px;">
                Tambah Sumber Air
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
                            <th>Sumber Air</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ref_sumber_air.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('ref_sumber_air.destroy', $item->id) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin hapus sumber air ini?')">
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
                            <td colspan="3" class="text-center text-muted">Belum ada data sumber air.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection