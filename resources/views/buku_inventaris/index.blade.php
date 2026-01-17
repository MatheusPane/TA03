@extends('layouts.layout')

@section('title', 'Buku Inventaris')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <!-- HEADER -->
        <div class="card-header bg-primary bg-gradient text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 fw-bold">Buku Inventaris Desa</h4>
                </div>
                <div class="col-auto">
                    @if(Auth::user()->hasRole(['Admin', 'Kader', 'Pengurus']))
                    <a href="{{ route('buku-inventaris.print-all') }}" target="_blank" 
                    class="btn btn-info border-2 fw-bold btn-sm d-flex align-items-center gap-2 shadow-sm me-2"
                    style="border-radius: 12px;">
                        <i class="bi bi-printer-fill"></i>
                        <span class="d-none d-sm-inline">Print Daftar</span>
                        <span class="d-sm-none">Print</span>
                    </a>
                
                        <a href="{{ route('buku-inventaris.create') }}" 
                           class="btn btn-light border-2 fw-bold btn-sm d-flex align-items-center gap-2 shadow-sm"
                           style="border-radius: 12px; min-width: 160px;">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span class="d-none d-sm-inline">Tambah Barang</span>
                            <span class="d-sm-none">Tambah</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive rounded-3 overflow-hidden shadow-sm">
                <table id="inventarisTable" class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background: linear-gradient(135deg, #0d6efd, #0d6dfdcc);">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Barang</th>
                            <th>Asal Barang</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jumlah</th>
                            <th>Tempat Penyimpanan</th>
                            <th>Kondisi</th>
                            <th width="240" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td data-sort="{{ $item->nama_barang }}"><strong>{{ $item->nama_barang }}</strong></td>
                                <td data-sort="{{ $item->asal_barang }}">{{ $item->asal_barang }}</td>
                                <td data-sort="{{ $item->tanggal_pembelian ? $item->tanggal_pembelian->timestamp : 0 }}">
                                    {{ $item->tanggal_pembelian ? $item->tanggal_pembelian->format('d/m/Y') : '-' }}
                                </td>
                                <td data-sort="{{ $item->jumlah }}">{{ $item->jumlah }}</td>
                                <td data-sort="{{ $item->tempat_penyimpanan }}">{{ $item->tempat_penyimpanan }}</td>
                                <td data-sort="{{ $item->kondisi_barang }}">
                                    <span class="badge rounded-pill {{ $item->kondisi_barang == 'Baik' ? 'bg-success' : ($item->kondisi_barang == 'Cukup Baik' ? 'bg-info' : 'bg-danger') }}">
                                        {{ $item->kondisi_barang }}
                                    </span>
                                </td>
                                <td class="aksi-column text-center"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                                    Belum ada data barang di inventaris.
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css">

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .dt-button {
        border-radius: 10px !important;
        font-weight: 600 !important;
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
        canEdit: @json(Auth::user()->hasRole(['Admin', 'Kader', 'Pengurus'])),
        canDelete: @json(Auth::user()->hasRole('Admin')),
        canView: true, // Semua role bisa lihat detail
        routes: {
            show: '{{ route('buku-inventaris.show', ':id') }}',
            edit: '{{ route('buku-inventaris.edit', ':id') }}',
            destroy: '{{ route('buku-inventaris.destroy', ':id') }}'
        }
    };

    $('#inventarisTable').DataTable({
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
            { targets: 0, width: "60px", className: "text-center" },
            { targets: -1, orderable: false, width: "180px", className: "text-center" }
        ],
        order: [[0, 'asc']],
        drawCallback: function () {
            $('#inventarisTable tbody tr').each(function () {
                const id = $(this).data('id');
                if (!id) return;

                let btn = '<div class="btn-group" role="group">';

                // Tombol Show (selalu muncul untuk semua role)
                btn += `<a href="${window.Laravel.routes.show.replace(':id', id)}" class="btn btn-sm btn-info" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>`;

                // Tombol Edit (Admin, Kader, Pengurus)
                if (window.Laravel.canEdit) {
                    btn += `<a href="${window.Laravel.routes.edit.replace(':id', id)}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>`;
                }

                // Tombol Hapus (hanya Admin)
                if (window.Laravel.canDelete) {
                    btn += `
                        <form action="${window.Laravel.routes.destroy.replace(':id', id)}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini dari inventaris?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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