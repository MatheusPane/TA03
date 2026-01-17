@extends('layouts.layout')

@section('title', 'Data Keluarga')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <!-- HEADER CANTIK + TOMBOL DI UJUNG KANAN + IKUT TEMA -->
        <div class="card-header bg-primary bg-gradient text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 fw-bold">Data Keluarga</h4>
                </div>
                <div class="col-auto">
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
                        <a href="{{ route('data_keluarga.create') }}" 
                           class="btn btn-light border-2 fw-bold d-flex align-items-center gap-2 shadow-sm"
                           style="border-radius: 12px; min-width: 150px;">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span class="d-none d-sm-inline">Tambah Keluarga</span>
                            <span class="d-sm-none">Tambah</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- ALERT SUCCESS -->
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- TABEL -->
            <div class="table-responsive rounded-3 overflow-hidden shadow-sm">
                <table id="dataKeluargaTable" class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background: linear-gradient(135deg, #0d6efd, #0d6dfdcc);">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>No KK</th>
                            <th>Dusun</th>
                            <th>Dasawisma</th>
                            <th>Dibuat Oleh</th>
                            <th width="90">Status</th>
                            <th width="240" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataKeluarga as $keluarga)
                            <tr data-id="{{ $keluarga->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $keluarga->no_kk }}</strong></td>
                                <td>{{ $keluarga->dusun->nama ?? '-' }}</td>
                                <td>{{ $keluarga->dasawisma->nama ?? '-' }}</td>
                                <td>{{ $keluarga->createdBy->name ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $keluarga->active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $keluarga->active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="aksi-column text-center"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css">

<style>
    /* Tombol export ikut tema */
    .dt-button {
        border-radius: 10px !important;
        font-weight: 600 !important;
    }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 10px;
        border: 1px solid var(--bs-border-color);
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
    }
    /* Hover tabel lebih halus */
    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    window.Laravel = {
        canEdit: @json(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')),
        canDelete: @json(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')),
        routes: {
            show: '{{ route('data_keluarga.show', ':id') }}',
            edit: '{{ route('data_keluarga.edit', ':id') }}',
            destroy: '{{ route('data_keluarga.destroy', ':id') }}',
            anggota_create: '{{ route('data_keluarga_anggota.create', ':id') }}',
            anggota_index: '{{ route('data_keluarga_anggota.index', ':id') }}',
            detail_edit: '{{ route('data_keluarga.detail.edit', ':id') }}'
        }
    };

    $('#dataKeluargaTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 15,
        lengthMenu: [10, 25, 50, 100, "Semua"],
        responsive: true,
        dom: '<"row mb-3"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'copy', text: '<i class="bi bi-copy"></i>', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'excel', text: '<i class="bi bi-file-excel"></i>', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: '<i class="bi bi-file-pdf"></i>', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: '<i class="bi bi-printer"></i>', className: 'btn btn-info btn-sm' }
        ],
        columnDefs: [
            { targets: 0, width: "50px", className: "text-center" },
            { targets: 5, width: "90px", className: "text-center" },
            { targets: 6, orderable: false, width: "240px", className: "text-center" }
        ],
        order: [[1, 'asc']],
        drawCallback: function() {
            $('#dataKeluargaTable tbody tr').each(function() {
                const id = $(this).data('id');
                if (!id) return;

                let btn = '<div class="btn-group" role="group">';

                btn += `<a href="${window.Laravel.routes.show.replace(':id', id)}" class="btn btn-sm btn-primary" title="Detail"><i class="bi bi-eye"></i></a>`;
                btn += `<a href="${window.Laravel.routes.anggota_create.replace(':id', id)}" class="btn btn-sm btn-success" title="Tambah Anggota"><i class="bi bi-person-plus"></i></a>`;
                btn += `<a href="${window.Laravel.routes.anggota_index.replace(':id', id)}" class="btn btn-sm btn-secondary" title="Lihat Anggota"><i class="bi bi-people"></i></a>`;

                if (window.Laravel.canEdit) {
                    btn += `<a href="${window.Laravel.routes.detail_edit.replace(':id', id)}" class="btn btn-sm btn-outline-warning" title="Fasilitas Rumah"><i class="bi bi-house-gear"></i></a>`;
                    btn += `<a href="${window.Laravel.routes.edit.replace(':id', id)}" class="btn btn-sm btn-warning" title="Edit KK"><i class="bi bi-pencil"></i></a>`;
                }

                if (window.Laravel.canDelete) {
                    btn += `<form action="${window.Laravel.routes.destroy.replace(':id', id)}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus keluarga ini dan semua anggotanya?')">
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