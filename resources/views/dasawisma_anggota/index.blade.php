@extends('layouts.layout')

@section('title', 'Anggota Dasawisma')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css">

<style>
    /* Page Container */
    .dasawisma-container {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    /* Page Header */
    .dasawisma-header {
        background: var(--bg-sidebar);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .dasawisma-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    }

    .dasawisma-header h4 {
        color: var(--text-primary);
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
    }

    .dasawisma-header .dasawisma-name {
        color: var(--primary);
        font-weight: 700;
    }

    .header-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-back {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .btn-back:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .btn-add {
        background: var(--primary);
        border: 1px solid var(--primary);
        color: white;
    }

    .btn-add:hover {
        background: var(--primary-dark);
        border: 1px solid var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
    }

    /* Alert */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-left: 4px solid #10b981;
        color: var(--text-primary);
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }

    .alert-success i {
        color: #10b981;
    }

    .alert .btn-close {
        filter: var(--bs-btn-close-filter, none);
    }

    /* DataTable Wrapper */
    .dataTables_wrapper {
        padding: 0;
    }

    .dataTables_wrapper .row {
        margin: 0;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 1rem;
        color: var(--text-primary);
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Table */
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin: 0 1rem 1rem;
    }

    .table {
        margin: 0;
        color: var(--text-primary);
    }

    .table thead {
        background: var(--bg-content);
        border-bottom: 2px solid var(--border-color);
        position: relative;
    }

    .table thead::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .table thead th {
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        color: var(--text-primary);
        border: none;
    }

    .table tbody td {
        padding: 1rem;
        border-color: var(--border-color);
        vertical-align: middle;
        font-size: 0.9375rem;
    }

    .table tbody tr:hover {
        background: var(--bg-content);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .badge.bg-info {
        background: rgba(14, 165, 233, 0.15) !important;
        color: #0ea5e9 !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3rem;
        display: block;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        color: var(--text-primary) !important;
        background: var(--bg-sidebar) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--bg-content) !important;
        border-color: var(--primary) !important;
        color: var(--primary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Info Text */
    .dataTables_info {
        color: var(--text-secondary) !important;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dasawisma-header {
            padding: 1.25rem;
        }

        .dasawisma-header h4 {
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: space-between;
        }

        .btn {
            flex: 1;
            justify-content: center;
        }

        .btn-add span.d-sm-none {
            display: inline !important;
        }

        .btn-add span.d-none {
            display: none !important;
        }

        .table-responsive {
            margin: 0 0.5rem 0.5rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .header-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="dasawisma-container">
        <!-- Header -->
        <div class="dasawisma-header">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md">
                    <h4>
                        <i class="bi bi-people-fill me-2"></i>
                        Anggota Dasawisma: <span class="dasawisma-name">{{ $dasawisma->nama }}</span>
                    </h4>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="header-actions">
                        <a href="{{ route('dasawisma.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                        @if(Auth::user()->hasRole(['Admin', 'Kader']))
                            <a href="{{ route('dasawisma_anggota.create', $dasawisma->id) }}" 
                               class="btn btn-add">
                                <i class="bi bi-person-plus-fill"></i>
                                <span class="d-none d-sm-inline">Tambah Anggota</span>
                                <span class="d-sm-none">Tambah</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="anggotaDasawismaTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Warga</th>
                            <th width="200">Peran</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>   
                    </thead>
                    
                    <tbody>
                        @forelse($anggota as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->warga->nama }}</strong></td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucwords(str_replace('_', ' ', $item->peran)) }}
                                    </span>
                                </td>
                        
                                <td class="text-center">
                        
                                    @if(Auth::user()->hasRole(['Admin', 'Kader']))
                                    <form action="{{ route('dasawisma_anggota.destroy', [$dasawisma->id, $item->id]) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                        
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                        
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <p class="mb-0">Belum ada anggota di dasawisma ini.</p>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#anggotaDasawismaTable').DataTable({
        language: { 
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ anggota",
            infoEmpty: "Menampilkan 0 hingga 0 dari 0 anggota",
            infoFiltered: "(difilter dari _MAX_ total anggota)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Belum ada data anggota"
        },
        pageLength: 15,
        lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Semua"]],
        responsive: true,
        order: [[1, 'asc']],
        columnDefs: [
            { targets: 0, orderable: false }
        ]
    });
});
</script>
@endpush