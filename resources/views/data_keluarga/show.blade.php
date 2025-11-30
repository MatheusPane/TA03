@extends('layouts.layout')

@section('title', 'Detail Keluarga: ' . $keluarga->no_kk)

@push('styles')
<style>
    /* Card Styling */
    .info-card {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .info-card .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-primary);
    }

    .card-title i {
        font-size: 1.125rem;
    }

    .card-title.text-primary i { color: var(--primary); }
    .card-title.text-info i { color: #0ea5e9; }
    .card-title.text-success i { color: #10b981; }
    .card-title.text-warning i { color: #f59e0b; }
    .card-title.text-secondary i { color: #64748b; }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-header .btn-light {
        background: rgba(255,255,255,0.95);
        border: none;
        color: var(--primary);
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .page-header .btn-light:hover {
        background: white;
        transform: translateY(-1px);
    }

    /* Data Table */
    .data-table {
        width: 100%;
        margin: 0;
    }

    .data-table tr {
        border: none;
    }

    .data-table td {
        padding: 0.625rem 0;
        color: var(--text-primary);
        font-size: 0.9375rem;
        border: none;
        vertical-align: top;
    }

    .data-table td:first-child {
        color: var(--text-secondary);
        width: 45%;
    }

    .data-table td strong {
        font-weight: 600;
    }

    /* Stats Box */
    .stat-box {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        transition: all 0.2s ease;
    }

    .stat-box:hover {
        border-color: var(--primary);
    }

    .stat-box h3,
    .stat-box h4 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.5rem;
    }

    .stat-box small {
        color: var(--text-secondary);
        font-size: 0.8125rem;
        font-weight: 500;
    }

    /* Color Classes */
    .text-primary { color: var(--primary) !important; }
    .text-info { color: #0ea5e9 !important; }
    .text-success { color: #10b981 !important; }
    .text-warning { color: #f59e0b !important; }
    .text-danger { color: #ef4444 !important; }
    .text-pink { color: #ec4899 !important; }
    .text-purple { color: #8b5cf6 !important; }
    .text-teal { color: #14b8a6 !important; }
    .text-secondary { color: #64748b !important; }

    /* Badge */
    .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .badge.bg-success {
        background: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
    }

    .badge.bg-danger {
        background: rgba(239, 68, 68, 0.15) !important;
        color: #ef4444 !important;
    }

    .badge.bg-warning {
        background: rgba(245, 158, 11, 0.15) !important;
        color: #f59e0b !important;
    }

    .badge.bg-info {
        background: rgba(14, 165, 233, 0.15) !important;
        color: #0ea5e9 !important;
    }

    .badge.bg-pink {
        background: rgba(236, 72, 153, 0.15) !important;
        color: #ec4899 !important;
    }

    /* Table Responsive */
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .table {
        margin-bottom: 0;
        color: var(--text-primary);
    }

    .table thead {
        background: var(--bg-content);
    }

    .table thead th {
        border: none;
        padding: 0.875rem 1rem;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .table tbody td {
        padding: 0.875rem 1rem;
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
    }

    .btn-success {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        border-color: #059669;
    }

    .btn-warning {
        background: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        border-color: #d97706;
    }

    .btn-secondary {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    /* Audit Info */
    .audit-info {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.8;
    }

    .audit-info strong {
        color: var(--text-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            text-align: center;
        }

        .stat-box h3,
        .stat-box h4 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('data_keluarga.print_dasawisma', $keluarga->id) }}" 
               class="btn btn-success" target="_blank">
                <i class="bi bi-printer"></i> Print Form Dasa Wisma
            </a>
        </div>
        <h4>
            <i class="bi bi-house-heart-fill"></i>
            Detail Keluarga: {{ $keluarga->no_kk }}
        </h4>
        <a href="{{ route('data_keluarga.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <!-- Identitas Keluarga -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-card-list"></i>
                        Identitas Keluarga
                    </h5>
                    <table class="data-table">
                        <tr>
                            <td><strong>No KK</strong></td>
                            <td>: <strong>{{ $keluarga->no_kk }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Dusun</strong></td>
                            <td>: {{ $keluarga->dusun->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dasawisma</strong></td>
                            <td>: {{ $keluarga->dasawisma->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                <span class="badge bg-{{ $keluarga->active ? 'success' : 'danger' }}">
                                    {{ $keluarga->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statistik Anggota -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-info">
                        <i class="bi bi-people-fill"></i>
                        Statistik Anggota
                    </h5>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 class="text-primary">{{ $keluarga->detail->jumlah_anggota ?? 0 }}</h3>
                                <small>Total</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 class="text-info">{{ $keluarga->detail->laki_laki ?? 0 }}</h3>
                                <small>Laki-laki</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 class="text-pink">{{ $keluarga->detail->perempuan ?? 0 }}</h3>
                                <small>Perempuan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Kategori Khusus -->
        <div class="col-12">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-bar-chart-fill"></i>
                        Statistik Kategori Khusus
                    </h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-info">{{ $keluarga->detail->jumlah_kk ?? 1 }}</h4>
                                <small>Jumlah KK</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-success">{{ $keluarga->detail->balita ?? 0 }}</h4>
                                <small>Balita</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-warning">{{ $keluarga->detail->pus ?? 0 }}</h4>
                                <small>PUS</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-purple">{{ $keluarga->detail->wus ?? 0 }}</h4>
                                <small>WUS</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-danger">{{ $keluarga->detail->buta ?? 0 }}</h4>
                                <small>Buta</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-pink">{{ $keluarga->detail->ibu_hamil ?? 0 }}</h4>
                                <small>Ibu Hamil</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-teal">{{ $keluarga->detail->ibu_menyusui ?? 0 }}</h4>
                                <small>Ibu Menyusui</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-secondary">{{ $keluarga->detail->lansia ?? 0 }}</h4>
                                <small>Lansia</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Anggota -->
        <div class="col-12">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="bi bi-person-lines-fill"></i>
                        Daftar Anggota Keluarga
                    </h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Reg</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>JK</th>
                                    <th>Umur</th>
                                    <th>Perkawinan</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($keluarga->anggotaKeluarga as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->warga->no_registrasi ?? '-' }}</td>
                                    <td><strong>{{ $a->warga->nama }}</strong></td>
                                    <td>{{ $a->statusDalamKeluarga->nama ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $a->warga->jenis_kelamin == 'L' ? 'info' : 'pink' }}">
                                            {{ $a->warga->jenis_kelamin }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($a->warga->tanggal_lahir)->age }} thn</td>
                                    <td>{{ $a->warga->statusPerkawinan->nama ?? '-' }}</td>
                                    <td>{{ $a->warga->pendidikan->nama ?? '-' }}</td>
                                    <td>{{ $a->warga->pekerjaan->nama ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center" style="color: var(--text-secondary); padding: 2rem;">
                                        <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                        Belum ada anggota keluarga
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @canany(['Admin', 'Kader'])
                    <div class="mt-3">
                        <a href="{{ route('data_keluarga_anggota.create', $keluarga->id) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Anggota
                        </a>
                    </div>
                    @endcanany
                </div>
            </div>
        </div>

        <!-- Fasilitas & Kriteria Rumah -->
        <div class="col-12">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-warning">
                        <i class="bi bi-house-check-fill"></i>
                        Fasilitas & Kriteria Rumah
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="data-table">
                                <tr>
                                    <td><strong>Makanan Pokok</strong></td>
                                    <td>: {{ $keluarga->detail->makanan_pokok ?? '-' }}
                                        @if($keluarga->detail->makanan_pokok == 'Non Beras')
                                            <small style="color: var(--text-secondary);">({{ optional($keluarga->detail->makananPokokLain)->nama ?? '-' }})</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Jamban</strong></td>
                                    <td>: {{ $keluarga->detail->punya_jamban ? 'Ya (' . $keluarga->detail->jumlah_jamban . ')' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sumber Air</strong></td>
                                    <td>: {{ optional($keluarga->detail->sumberAir)->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tempat Sampah</strong></td>
                                    <td>: {{ $keluarga->detail->punya_tempat_sampah ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="data-table">
                                <tr>
                                    <td><strong>Saluran Limbah</strong></td>
                                    <td>: {{ $keluarga->detail->punya_saluran_limbah ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Stiker P4K</strong></td>
                                    <td>: {{ $keluarga->detail->stiker_p4k ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kriteria Rumah</strong></td>
                                    <td>: 
                                        <span class="badge bg-{{ $keluarga->detail->kriteria_rumah == 'Sehat' ? 'success' : 'warning' }}">
                                            {{ $keluarga->detail->kriteria_rumah ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>UP2K</strong></td>
                                    <td>: {{ $keluarga->detail->up2k ? 'Ya' : 'Tidak' }}
                                        @if($keluarga->detail->up2k)
                                            <small style="color: var(--text-secondary);">({{ optional($keluarga->detail->jenisUsaha)->nama ?? '-' }})</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Kesehatan Lingkungan</strong></td>
                                    <td>: {{ $keluarga->detail->kesehatan_lingkungan ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @canany(['Admin', 'Kader'])
                    <div class="mt-3">
                        <a href="{{ route('data_keluarga.detail.edit', $keluarga->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit Detail Fasilitas
                        </a>
                    </div>
                    @endcanany
                </div>
            </div>
        </div>

        <!-- Audit Trail -->
        <div class="col-12">
            <div class="info-card">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        <i class="bi bi-clock-history"></i>
                        Riwayat
                    </h5>
                    <div class="audit-info">
                        <i class="bi bi-person-plus me-1"></i>
                        Dibuat oleh: <strong>{{ $keluarga->createdBy->name ?? '-' }}</strong>
                        pada {{ $keluarga->created_at ? \Carbon\Carbon::parse($keluarga->created_at)->format('d/m/Y H:i') : '-' }}
                        <br>
                        <i class="bi bi-pencil me-1"></i>
                        Diperbarui oleh: <strong>{{ $keluarga->updatedBy->name ?? '-' }}</strong>
                        pada {{ $keluarga->updated_at ? \Carbon\Carbon::parse($keluarga->updated_at)->format('d/m/Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                @canany(['Admin', 'Kader'])
                <a href="{{ route('data_keluarga.edit', $keluarga->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit KK
                </a>
                @endcanany
                <a href="{{ route('data_keluarga.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection