@extends('layouts.layout')

@section('title', 'Data Keluarga')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
        <div class="card-header-custom" style="border-bottom: 2px solid rgba(0, 0, 0, 0.05); padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="font-weight: 700; color: var(--text-dark); margin: 0;">Data Keluarga</h4>
            @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
                <a href="{{ route('data_keluarga.create') }}" class="btn btn-primary" style="border-radius: 10px;">
                    <i class="bi bi-plus-circle"></i> Tambah Keluarga
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert" style="border-radius: 10px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="p-3">
            <div class="table-responsive">
                <table id="dataKeluargaTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;">
                        <tr>
                            <th>No</th>
                            <th>No KK</th>
                            <th>Dusun</th>
                            <th>Dasawisma</th>
                            <th>Dibuat Oleh</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataKeluarga as $keluarga)
                            <tr data-id="{{ $keluarga->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $keluarga->no_kk }}</td>
                                <td>{{ $keluarga->dusun->nama ?? '-' }}</td>
                                <td>{{ $keluarga->dasawisma->nama ?? '-' }}</td>
                                <td>{{ $keluarga->createdBy->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $keluarga->active ? 'success' : 'secondary' }}">
                                        {{ $keluarga->active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="aksi-column"></td>
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
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    window.Laravel = {
        canEdit: @json(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader')),
        canDelete: @json(Auth::user()->hasRole('Admin')),
        routes: {
            show: '{{ route('data_keluarga.show', ':id') }}',
            edit: '{{ route('data_keluarga.edit', ':id') }}',
            destroy: '{{ route('data_keluarga.destroy', ':id') }}',
            anggota_create: '{{ route('data_keluarga_anggota.create', ':id') }}',
            anggota_index: '{{ route('data_keluarga_anggota.index', ':id') }}',
            detail_edit: '{{ route('data_keluarga.detail.edit', ':id') }}'
        }
    };

    const table = $('#dataKeluargaTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'copy', text: 'Copy', className: 'btn btn-secondary btn-sm' },
            { extend: 'excel', text: 'Excel', className: 'btn btn-success btn-sm', title: 'Data Keluarga' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm', title: 'Data Keluarga' },
            { extend: 'print', text: 'Print', className: 'btn btn-info btn-sm', title: 'Data Keluarga' }
        ],
        columnDefs: [
            { targets: 0, width: '50px', className: 'text-center' },
            { targets: 1, width: '150px' },
            { targets: 6, orderable: false, width: '220px', className: 'text-center' }
        ],
        order: [[1, 'asc']],
        drawCallback: function() {
            $('#dataKeluargaTable tbody tr').each(function() {
                const id = $(this).data('id');
                if (!id) return;

                let btn = `<div class="btn-group" role="group">`;

                // Lihat Detail
                btn += `<a href="${window.Laravel.routes.show.replace(':id', id)}" class="btn btn-sm btn-info" title="Detail Keluarga">
                    <i class="bi bi-eye"></i>
                </a>`;

                // Tambah Anggota
                btn += `<a href="${window.Laravel.routes.anggota_create.replace(':id', id)}" class="btn btn-sm btn-success" title="Tambah Anggota">
                    <i class="bi bi-person-plus"></i>
                </a>`;

                // Lihat Anggota
                btn += `<a href="${window.Laravel.routes.anggota_index.replace(':id', id)}" class="btn btn-sm btn-secondary" title="Lihat Anggota">
                    <i class="bi bi-people"></i>
                </a>`;

                if (window.Laravel.canEdit) {
                    btn += `<a href="${window.Laravel.routes.detail_edit.replace(':id', id)}" class="btn btn-sm btn-outline-warning" title="Isi Detail Fasilitas">
                        <i class="bi bi-house-gear"></i>
                    </a>`;
                    btn += `<a href="${window.Laravel.routes.edit.replace(':id', id)}" class="btn btn-sm btn-warning" title="Edit KK">
                        <i class="bi bi-pencil"></i>
                    </a>`;
                }

                if (window.Laravel.canDelete) {
                    btn += `<form action="${window.Laravel.routes.destroy.replace(':id', id)}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus keluarga ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>`;
                }

                btn += `</div>`;
                $(this).find('.aksi-column').html(btn);
            });

            $('.dataTables_paginate .page-link').addClass('border-0');
        }
    });

    // Render pertama
    table.draw();
});
</script>
@endpush