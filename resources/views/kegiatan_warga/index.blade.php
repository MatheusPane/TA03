@extends('layouts.layout')

@section('title', 'Kegiatan Warga: ' . $warga->nama)

@push('styles')
<style>
    /* ============================
   FIX DARK/LIGHT MODE — FOLLOW STYLE DASAWISMA
   ============================ */

/* Container */
.kegiatan-container {
    background: var(--bg-content);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

/* Header */
.kegiatan-header {
    background: var(--bg-content);
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.kegiatan-header h4 {
    margin: 0;
    font-weight: 700;
    color: var(--text-dark);
}

.btn-dashboard {
    background: var(--primary);
    border-radius: 8px;
    border: none;
    color: white;
    font-weight: 600;
}
.btn-dashboard:hover {
    background: var(--primary-dark);
}

.btn-back {
    background: var(--bg-content);
    border: 1px solid rgba(0,0,0,0.15);
    color: var(--text-dark);
    border-radius: 8px;
    font-weight: 600;
}
[data-theme="dark"] .btn-back {
    border-color: rgba(255,255,255,0.2);
    color: white;
}
.btn-back:hover {
    background: rgba(0,0,0,0.08);
}

/* Table Header – Fix seperti halaman Dasawisma */
.kegiatan-container table thead {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
}
.kegiatan-container table thead th {
    border: none !important;
    padding: 12px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

/* Table Body */
.kegiatan-container table tbody td {
    color: var(--text-dark);
    padding: 12px;
    border-color: rgba(0,0,0,0.1);
}
[data-theme="dark"] .kegiatan-container table tbody td {
    color: white;
    border-color: rgba(255,255,255,0.15);
}

.kegiatan-container table tbody tr:hover {
    background: rgba(0,0,0,0.05);
}
[data-theme="dark"] .kegiatan-container table tbody tr:hover {
    background: rgba(255,255,255,0.07);
}

/* Input Fix */
.kegiatan-container .form-control {
    border-radius: 8px;
    background: var(--bg-content);
    color: var(--text-dark);
    border: 1px solid rgba(0,0,0,0.1);
}
[data-theme="dark"] .kegiatan-container .form-control {
    background: var(--bg-sidebar);
    color: white;
    border-color: rgba(255,255,255,0.2);
}

/* Radio Buttons */
.btn-outline-success {
    border-color: #10b981;
    color: #10b981;
}
.btn-outline-success:hover,
.btn-check:checked + .btn-outline-success {
    background: #10b981;
    color: white;
}

.btn-outline-secondary {
    border-color: rgba(0,0,0,0.25);
    color: var(--text-dark);
}
[data-theme="dark"] .btn-outline-secondary {
    border-color: rgba(255,255,255,0.25);
    color: white;
}
.btn-outline-secondary:hover,
.btn-check:checked + .btn-outline-secondary {
    background: rgba(0,0,0,0.1);
}
[data-theme="dark"] .btn-outline-secondary:hover {
    background: rgba(255,255,255,0.15);
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
                    <i class="bi bi-speedometer2"></i> Kembali
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
