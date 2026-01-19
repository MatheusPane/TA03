@extends('layouts.layout')

@section('title', 'Statistik Dusun')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">

        <!-- HEADER -->
        <div class="card-header bg-primary bg-gradient text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-bar-chart-fill me-2"></i>
                        Statistik Penduduk Per Dusun
                    </h4>
                </div>
        
                <div class="col-auto">
                    <a href="{{ route('statistik.dusun.print') }}"
                       target="_blank"
                       class="btn btn-danger btn-sm shadow-sm">
                        <i class="bi bi-printer me-1"></i> Cetak
                    </a>
                </div>
            </div>
        </div>
        
        <!-- END HEADER -->

        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="statistikDusunTable" class="table table-hover align-middle w-100">
                    <thead class="text-white" style="background: linear-gradient(135deg, #0d6efd, #0d6dfdcc);">
                        <tr>
                            <th>No</th>
                            <th>Nama Dusun</th>
                            <th>Jumlah Dasawisma</th>
                            <th>Jumlah KK</th>
                            <th>Jiwa Laki-laki</th>
                            <th>Jiwa Perempuan</th>
                            <th>Total Jiwa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statistik as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $row->nama_dusun }}</strong></td>
                            <td class="text-center">{{ $row->jumlah_dasawisma }}</td>
                            <td class="text-center">{{ $row->jumlah_kk }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">
                                    {{ $row->jumlah_laki }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-pink">
                                    {{ $row->jumlah_perempuan }}
                                </span>
                            </td>
                            <td class="text-center fw-bold">
                                {{ $row->jumlah_laki + $row->jumlah_perempuan }}
                            </td>
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
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 1px solid var(--bs-border-color);
    }
    .dt-button {
        border-radius: 8px !important;
        font-size: 0.875rem !important;
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
$(document).ready(function () {
    $('#statistikDusunTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100, "Semua"],
        responsive: true,
        dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-5"i><"col-md-7"p>>',
        buttons: [
            { extend: 'copy', text: '<i class="bi bi-copy"></i>', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'excel', text: '<i class="bi bi-file-excel"></i>', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: '<i class="bi bi-file-pdf"></i>', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: '<i class="bi bi-printer"></i>', className: 'btn btn-info btn-sm' }
        ],
        columnDefs: [
            { targets: 0, width: "50px", className: "text-center" },
            { targets: [2,3,4,5,6], className: "text-center" }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endpush
