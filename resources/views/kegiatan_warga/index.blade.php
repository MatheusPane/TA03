@extends('layouts.layout')

@section('title', 'Kegiatan Warga: ' . $warga->nama)

@push('styles')
<style>
    /* Container */
    
    .kegiatan-container {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    /* Header */
    .kegiatan-header {
        background: var(--bg-sidebar);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .kegiatan-header::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    }

    .kegiatan-header h4 {
        margin: 0;
        font-weight: 700;
        color: var(--text-primary);
    }

    .header-buttons .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.45rem 1rem;
    }

    .btn-back {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    .btn-back:hover {
        background: var(--border-color);
    }

    .btn-dashboard {
        background: var(--primary);
        border: 1px solid var(--primary);
        color: white;
    }
    .btn-dashboard:hover {
        background: var(--primary-dark);
    }

    /* Table */
    table {
        color: var(--text-primary);
    }

    .table thead {
        background: var(--bg-content);
        border-bottom: 2px solid var(--border-color);
        position: relative;
    }
    .table thead::after {
        content: '';
        position: absolute;
        left: 0; right: 0; bottom: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .table thead th {
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        color: var(--text-primary);
        border: none;
    }

    .table td {
        padding: 1rem;
        border-color: var(--border-color);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: var(--bg-content);
    }

    /* Input */
    .form-control {
        background: var(--bg-content);
        color: var(--text-primary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .btn-outline-success,
    .btn-outline-secondary {
        border-radius: 6px;
    }

    .btn-outline-success {
        color: #10b981;
        border-color: #10b981;
    }
    .btn-outline-success:hover,
    .btn-check:checked + .btn-outline-success {
        background: #10b981;
        color: white;
    }

    .btn-outline-secondary {
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    .btn-outline-secondary:hover,
    .btn-check:checked + .btn-outline-secondary {
        background: var(--border-color);
        color: var(--text-primary);
    }
    

</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="kegiatan-container">

        <!-- Header -->
        <div class="kegiatan-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h4>
                <i class="bi bi-list-task me-2"></i>
                Kegiatan Warga: {{ $warga->nama }}
            </h4>

            <div class="header-buttons d-flex gap-2">
                <a href="{{ route('kegiatan_warga.dashboard') }}" class="btn btn-dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('data_warga.show', $warga->id) }}" class="btn btn-back">
                    <i class="bi bi-person"></i> Profil
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="p-4">
            <form id="kegiatanForm">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Aktivitas</th>
                                <th width="160">Ikut?</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($refKegiatan as $ref)
                            @php
                                $keg = $kegiatanWarga->get($ref->id);
                                $isIkut = $keg?->ikut ?? false;
                                $keterangan = $keg?->keterangan ?? '';
                            @endphp

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td><strong>{{ $ref->nama }}</strong></td>

                                <td>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check"
                                            name="ikut_{{ $ref->id }}" id="ya_{{ $ref->id }}"
                                            value="1" {{ $isIkut ? 'checked' : '' }}
                                            onchange="saveKegiatan({{ $warga->id }}, {{ $ref->id }}, this.value, document.getElementById('ket_{{ $ref->id }}').value)">

                                        <label class="btn btn-sm btn-outline-success w-50"
                                            for="ya_{{ $ref->id }}">Ya</label>

                                        <input type="radio" class="btn-check"
                                            name="ikut_{{ $ref->id }}" id="tidak_{{ $ref->id }}"
                                            value="0" {{ !$isIkut ? 'checked' : '' }}
                                            onchange="saveKegiatan({{ $warga->id }}, {{ $ref->id }}, this.value, document.getElementById('ket_{{ $ref->id }}').value)">

                                        <label class="btn btn-sm btn-outline-secondary w-50"
                                            for="tidak_{{ $ref->id }}">Tidak</label>
                                    </div>
                                </td>

                                <td>
                                    <input type="text" id="ket_{{ $ref->id }}"
                                        class="form-control form-control-sm"
                                        value="{{ $keterangan }}"
                                        placeholder="Jenis kegiatan..."
                                        onblur="saveKegiatan({{ $warga->id }}, {{ $ref->id }},
                                            document.querySelector('input[name=\'ikut_{{ $ref->id }}\']:checked')?.value ?? 0,
                                            this.value)">
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada referensi kegiatan.  
                                    <a href="{{ route('ref_kegiatan_warga.create') }}" class="text-primary">
                                        Tambah dulu
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveKegiatan(warga_id, ref_id, ikut, keterangan) {
    fetch(`/warga/${warga_id}/kegiatan`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ref_kegiatan_id: ref_id,
            ikut: ikut,
            keterangan: keterangan
        })
    })
    .then(res => res.json())
    .then(data => console.log("Saved:", data))
    .catch(err => console.error(err));
}
</script>
@endsection
