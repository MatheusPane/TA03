@extends('layouts.layout')

@section('title', 'Anggota Dasawisma')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <!-- HEADER CANTIK + TOMBOL DI UJUNG KANAN -->
        <div class="card-header bg-primary bg-gradient text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 fw-bold">
                        Anggota Dasawisma: <span class="text-warning">{{ $dasawisma->nama }}</span>
                    </h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dasawisma.index') }}" class="btn btn-outline-light btn-sm me-2">
                        ← Kembali
                    </a>
                    @if(Auth::user()->hasRole(['Admin', 'Kader']))
                        <a href="{{ route('dasawisma_anggota.create', $dasawisma->id) }}" 
                           class="btn btn-light border-2 fw-bold btn-sm d-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-person-plus-fill"></i>
                            <span class="d-none d-sm-inline">Tambah Anggota</span>
                            <span class="d-sm-none">Tambah</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="anggotaDasawismaTable" class="table table-hover align-middle w-100">
                    <thead class="text-white" style="background: linear-gradient(135deg, #0d6efd, #0d6dfdcc);">
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Warga</th>
                            <th width="160">Peran</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->warga->nama }}</strong></td>
                                <td>
                                    <span class="badge rounded-pill bg-info text-white px-3 py-2">
                                        {{ ucwords(str_replace('_', ' ', $item->peran)) }}
                                    </span>
                                </td>
                                <td class="aksi-column text-center"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                                    Belum ada anggota di dasawisma ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css">

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 10px;
        border: 1px solid var(--bs-border-color);
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    // SESUAI DENGAN ROUTE KAMU: /dasawisma/{id}/anggota/{anggota_id}
    const baseUrl = '{{ route("dasawisma_anggota.index", $dasawisma->id) }}'.replace(/\/$/, '') + '/';

    window.Laravel = {
        canEdit: @json(Auth::user()->hasRole(['Admin', 'Kader'])),
        canDelete: @json(Auth::user()->hasRole('Admin')),
        baseUrl: baseUrl  // → http://localhost/dasawisma/5/anggota/
    };

    $('#anggotaDasawismaTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 15,
        lengthMenu: [10, 25, 50, "Semua"],
        responsive: true,
        ordering: true,
        order: [[1, 'asc']],
        columnDefs: [
            { targets: [0, 3], orderable: false }
        ],
        drawCallback: function () {
            $('#anggotaDasawismaTable tbody tr').each(function () {
                const id = $(this).data('id');
                if (!id) return;

                let btn = '<div class="btn-group" role="group">';

                // EDIT (Admin & Kader)
                if (window.Laravel.canEdit) {
                    btn += `<a href="${window.Laravel.baseUrl}${id}/edit" class="btn btn-sm btn-warning" title="Edit Peran">
                                <i class="bi bi-pencil"></i>
                            </a>`;
                }

                // HAPUS (Hanya Admin)
                if (window.Laravel.canDelete) {
                    btn += `
                        <form action="${window.Laravel.baseUrl}${id}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus anggota ini dari dasawisma?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus dari Dasawisma">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>`;
                }

                btn += '</div>';
                $(this).find('.aksi-column').html(btn);
            });
        }
    });
});
</script>
@endpush