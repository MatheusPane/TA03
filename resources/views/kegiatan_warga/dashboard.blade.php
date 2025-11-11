@extends('layouts.layout')

@section('title', 'Dashboard Kegiatan Warga')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Dashboard Kegiatan Warga
            </h4>
        </div>

        @if(!$hasRefKegiatan)
        <div class="alert alert-warning mx-3 mt-3" role="alert" style="border-radius: 10px;">
            <strong>Referensi Kegiatan belum ada!</strong><br>
            <a href="{{ route('ref_kegiatan_warga.create') }}" class="btn btn-sm btn-warning mt-2">
                Tambah Referensi Kegiatan
            </a>
        </div>
        @endif

        <div class="p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Warga</th>
                            <th width="180">No KTP</th>
                            <th width="150">Jumlah Kegiatan</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargaList as $warga)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration + ($wargaList->currentPage() - 1) * $wargaList->perPage() }}
                            </td>
                            <td>{{ $warga->nama }}</td>
                            <td>{{ $warga->no_ktp ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $warga->kegiatan_aktif_count > 0 ? 'success' : 'secondary' }}">
                                    {{ $warga->kegiatan_aktif_count }} aktif
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('kegiatan_warga.index', $warga->id) }}" 
                                   class="btn btn-sm {{ $warga->kegiatan_aktif_count > 0 ? 'btn-primary' : 'btn-outline-primary' }}"
                                   title="{{ $warga->kegiatan_aktif_count > 0 ? 'Lihat & Edit' : 'Mulai Isi Kegiatan' }}">
                                    {{ $warga->kegiatan_aktif_count > 0 ? 'Lihat' : 'Isi' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle"></i><br>
                                Belum ada data warga.<br>
                                <a href="{{ route('data_warga.create') }}" class="btn btn-sm btn-link">Tambah Warga</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $wargaList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection