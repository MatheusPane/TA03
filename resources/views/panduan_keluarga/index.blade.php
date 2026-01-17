@extends('layouts.layout')

@section('title', 'Panduan Catatan Keluarga PKK')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="border-bottom: 2px solid rgba(0,0,0,0.05); padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="font-weight: 700; color: var(--text-dark); margin: 0;">Panduan Catatan Keluarga PKK</h4>
            @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Pengurus'))
                <a href="{{ route('panduan_keluarga.show', $keluargaList->first()->id ?? 1) }}" class="btn btn-primary" style="border-radius: 10px;">
                    Lihat Contoh
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
                <table id="panduanKeluargaTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;">
                        <tr>
                            <th>No</th>
                            <th>No KK</th>
                            <th>Dusun</th>
                            <th>Dasawisma</th>
                            <th>Kepala Keluarga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluargaList as $keluarga)
                        @php
                            $kepalaAnggota = $keluarga->anggotaKeluarga
                                ->firstWhere(fn($a) => 
                                    $a->statusDalamKeluarga && 
                                    str_contains(strtolower($a->statusDalamKeluarga->nama), 'kepala')
                                );
                            $kepala = $kepalaAnggota?->warga;
                        @endphp
                        <tr data-id="{{ $keluarga->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $keluarga->no_kk }}</td>
                            <td>{{ $keluarga->dusun?->nama ?? '-' }}</td>
                            <td>{{ $keluarga->dasawisma?->nama ?? '-' }}</td>
                            <td>
                                <strong>{{ $kepala?->nama ?? 'Belum ditentukan' }}</strong>
                                @if($kepala)
                                    <span class="badge bg-primary ms-1 small">KRT</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $keluarga->active ? 'success' : 'secondary' }}">
                                    {{ $keluarga->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="aksi-column"></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-house fs-3"></i><br>
                                <strong>Belum ada data keluarga yang lengkap.</strong><br>
                                <small>Pastikan ada anggota dengan status "Kepala Keluarga" dan detail rumah.</small>
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
        canView: @json(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Pengurus')),
        routes: {
            show: '{{ route('panduan_keluarga.show', ':id') }}'
        }
    };

    const table = $('#panduanKeluargaTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'copy', text: 'Copy', className: 'btn btn-secondary btn-sm' },
            { extend: 'excel', text: 'Excel', className: 'btn btn-success btn-sm', title: 'Panduan Keluarga PKK' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm', title: 'Panduan Keluarga PKK' },
            { extend: 'print', text: 'Print', className: 'btn btn-info btn-sm', title: 'Panduan Keluarga PKK' }
        ],
        columnDefs: [
            { targets: 0, width: '50px', className: 'text-center' },
            { targets: 6, orderable: false, width: '100px', className: 'text-center' }
        ],
        order: [[1, 'asc']],
        drawCallback: function() {
            $('#panduanKeluargaTable tbody tr').each(function() {
                const id = $(this).data('id');
                if (!id || !window.Laravel.canView) return;

                const btn = `
                    <a href="${window.Laravel.routes.show.replace(':id', id)}" 
                       class="btn btn-sm btn-info" title="Lihat Catatan">
                        <i class="bi bi-file-text"></i>
                    </a>
                `;
                $(this).find('.aksi-column').html(btn);
            });
        }
    });

    table.draw();
});
</script>
@endpush