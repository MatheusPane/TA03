@extends('layouts.layout')

@section('title', 'Anggota Dasawisma')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
        <div class="card-header-custom" style="border-bottom: 2px solid rgba(0, 0, 0, 0.05); padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="font-weight: 700; color: var(--text-dark); margin: 0;">
                Anggota Dasawisma: {{ $dasawisma->nama }}
            </h4>
            <div>
                <a href="{{ route('dasawisma.index') }}" class="btn btn-secondary btn-sm" style="border-radius: 10px;">
                    Kembali
                </a>
                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
                    <a href="{{ route('dasawisma_anggota.create', $dasawisma->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;">
                        + Tambah Anggota
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert" style="border-radius: 10px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="p-3">
            <div class="table-responsive">
                <table id="anggotaDasawismaTable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;">
                        <tr>
                            <th>No</th>
                            <th>Nama Warga</th>
                            <th>Peran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $a)
                            <tr data-id="{{ $a->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->warga->nama }}</td>
                                <td>
                                    <span class="badge bg-info text-white">
                                        {{ ucwords(str_replace('_', ' ', $a->peran)) }}
                                    </span>
                                </td>
                                <td class="aksi-column"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada anggota.</td>
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

<s<script>
    $(document).ready(function() {
        const baseUrl = '{{ url('dasawisma/' . $dasawisma->id . '/anggota') }}';
    
        window.Laravel = {
            canEdit: @json(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader')),
            canDelete: @json(Auth::user()->hasRole('Admin')),
            baseUrl: baseUrl + '/'  // hasil: /dasawisma/2/anggota/
        };
    
        // ... DataTable init
    
        drawCallback: function() {
            $('#anggotaDasawismaTable tbody tr').each(function() {
                const id = $(this).data('id');
                if (!id) return;
    
                let buttons = `<div class="btn-group" role="group">`;
    
                if (window.Laravel.canEdit) {
                    buttons += `<a href="${window.Laravel.baseUrl}${id}/edit" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>`;
                }
    
                if (window.Laravel.canDelete) {
                    buttons += `
                        <form action="${window.Laravel.baseUrl}${id}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>`;
                }
    
                buttons += `</div>`;
                $(this).find('.aksi-column').html(buttons);
            });
        }
    });
    </script>
@endpush