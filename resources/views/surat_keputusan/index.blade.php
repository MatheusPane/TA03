{{-- resources/views/surat_keputusan/index.blade.php --}}
@extends('layouts.layout')

@section('title', 'Daftar Surat Keputusan PKK')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">
                <i class="bi bi-file-earmark-text"></i> Daftar Surat Keputusan PKK
            </h4>
            <a href="{{ route('surat_keputusan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Buat Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="suratTable">
                <thead class="table-primary">
                    <tr>
                        <th width="50">No</th>
                        <th>Nomor SK</th>
                        <th>Tentang</th>
                        <th>Tanggal</th>
                        <th>Dibuat Oleh</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nomor }}</strong></td>
                            <td>{{ Str::limit($item->tentang, 50) }}</td>
                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $item->creator?->nama ?? 'Sistem' }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('surat_keputusan.show', $item) }}"
                                       class="btn btn-info btn-sm" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('surat_keputusan.edit', $item) }}"
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('surat_keputusan.cetak', $item) }}"
                                       target="_blank"
                                       class="btn btn-success btn-sm" title="Cetak PDF">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <form action="{{ route('surat_keputusan.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin HAPUS PERMANEN? Data tidak bisa dikembalikan!')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1"></i><br>
                                <strong>Belum ada Surat Keputusan</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#suratTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 10,
        responsive: true,
        order: [[3, 'desc']]
    });
});
</script>
@endpush