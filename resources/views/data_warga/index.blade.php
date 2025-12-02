@extends('layouts.layout')

@section('title', 'Data Warga')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <!-- HEADER YANG BENAR-BENAR FIX -->
                <div class="card-header bg-primary bg-gradient text-white position-relative">
                    <div class="row align-items-center g-3">
                        <div class="col">
                            <h4 class="mb-0 fw-bold">Data Warga</h4>
                        </div>
                        <div class="col-auto">
                            @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
                                <a href="{{ route('data_warga.create') }}" 
                                   class="btn btn-tombol-tambah d-flex align-items-center gap-2 shadow-sm fw-bold"
                                   style="border-radius: 12px; min-width: 140px;">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <span class="d-none d-sm-inline">Tambah Data</span>
                                    <span class="d-sm-none">Tambah</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
        <!-- END HEADER FIX -->

        <div class="card-body p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="dataWargaTable" class="table table-hover align-middle w-100">
                    <thead class="text-white" style="background: linear-gradient(135deg, #0d6efd, #0d6dfdcc);">
                        <tr>
                            <th>No</th>
                            <th>No Registrasi</th>
                            <th>No KTP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Jenis Kelamin</th>
                            <th>Status Perkawinan</th>
                            <th>Agama</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataWarga as $warga)
                            <tr data-id="{{ $warga->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $warga->no_registrasi ?? '-' }}</td>
                                <td>{{ $warga->no_ktp ?? '-' }}</td>
                                <td><strong>{{ $warga->nama }}</strong></td>
                                <td>{{ $warga->jabatan?->nama ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $warga->jenis_kelamin == 'L' ? 'bg-info' : 'bg-pink' }} text-white">
                                        {{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td>{{ $warga->statusPerkawinan?->nama ?? '-' }}</td>
                                <td>{{ $warga->agama?->nama ?? '-' }}</td>
                                <td>{{ $warga->pendidikan?->nama ?? '-' }}</td>
                                <td>{{ $warga->pekerjaan?->nama ?? '-' }}</td>
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
    .bg-pink { background-color: #e91e63 !important; }
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.1) !important; }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 1px solid var(--bs-border-color);
    }
    .dt-button {
        border-radius: 8px !important;
        font-size: 0.875rem !important;
    }
    /* Tombol Tambah Data — otomatis hitam/putih sesuai mode */
.btn-tombol-tambah {
    background-color: rgba(var(--bs-body-bg-rgb), 0.9) !important;
    color: var(--bs-body-color) !important;
    border: 2px solid var(--bs-border-color) !important;
    transition: all 0.3s ease;
}

.btn-tombol-tambah:hover {
    background-color: var(--bs-body-bg) !important;
    color: var(--bs-primary) !important;
    border-color: var(--bs-primary) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
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
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    window.Laravel = {
        canEdit: @json(Auth::user()->hasRole(['Admin', 'Kader'])),
        canDelete: @json(Auth::user()->hasRole('Admin')),
        routes: {
            show: '{{ route('data_warga.show', ':id') }}',
            edit: '{{ route('data_warga.edit', ':id') }}',
            destroy: '{{ route('data_warga.destroy', ':id') }}'
        }
    };

    $('#dataWargaTable').DataTable({
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
            { targets: [1,2], width: "130px" },
            { targets: 3, width: "200px" },
            { targets: -1, orderable: false, className: "text-center" }
        ],
        order: [[3, 'asc']],
        drawCallback: function () {
            $('#dataWargaTable tbody tr').each(function () {
                const id = $(this).data('id');
                if (!id) return;

                let btn = '<div class="btn-group" role="group">';
                btn += `<a href="${window.Laravel.routes.show.replace(':id', id)}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>`;
                
                if (window.Laravel.canEdit) {
                    btn += `<a href="${window.Laravel.routes.edit.replace(':id', id)}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>`;
                }
                if (window.Laravel.canDelete) {
                    btn += `<form action="${window.Laravel.routes.destroy.replace(':id', id)}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
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