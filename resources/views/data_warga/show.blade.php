@extends('layouts.layout')

@section('title', 'Detail Warga: ' . $warga->nama)

@push('styles')
<style>
    /* Page Container */
    .detail-container {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }

    /* Page Header */
    .detail-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .detail-header h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .detail-actions {
        display: flex;
        gap: 0.5rem;
    }

    .detail-actions .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-danger {
        background: #dc2626;
        border-color: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    .btn-light {
        background: rgba(255,255,255,0.95);
        border: none;
        color: var(--primary);
    }

    .btn-light:hover {
        background: white;
    }

    /* Content Body */
    .detail-body {
        padding: 2rem;
    }

    /* Section Cards */
    .section-card {
        padding-left: 1.25rem;
        border-left: 4px solid;
        margin-bottom: 2rem;
    }

    .section-card.identitas {
        border-color: var(--primary);
    }

    .section-card.sosial {
        border-color: #10b981;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        font-size: 1.25rem;
    }

    .section-card.identitas .section-title {
        color: var(--primary);
    }

    .section-card.sosial .section-title {
        color: #10b981;
    }

    /* Data Table */
    .info-table {
        width: 100%;
        margin: 0;
    }

    .info-table tr {
        border: none;
    }

    .info-table th {
        width: 160px;
        padding: 0.75rem 0;
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 0.9375rem;
        vertical-align: top;
    }

    .info-table td {
        padding: 0.75rem 0;
        color: var(--text-primary);
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .info-table td strong {
        font-weight: 700;
        font-size: 1.0625rem;
    }

    /* Kebutuhan Khusus Box */
    .kebutuhan-box {
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        border-left: 4px solid #ec4899;
        border-radius: 0 12px 12px 0;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .kebutuhan-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .kebutuhan-title i {
        color: #ec4899;
        font-size: 1.25rem;
    }

    .kebutuhan-status {
        margin-bottom: 0.75rem;
    }

    .kebutuhan-desc {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin: 0;
    }

    /* Divider */
    .section-divider {
        border: none;
        border-top: 1px solid var(--border-color);
        margin: 2.5rem 0;
    }

    /* Program Section */
    .program-section {
        margin-top: 2.5rem;
    }

    .program-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .program-title i {
        color: #0ea5e9;
        font-size: 1.25rem;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .program-item {
        padding: 1rem;
        background: var(--bg-content);
        border: 1px solid var(--border-color);
        border-radius: 10px;
    }

    .program-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        font-size: 0.9375rem;
    }

    .program-detail {
        color: var(--text-secondary);
        font-size: 0.8125rem;
        margin-top: 0.5rem;
    }

    /* Badge */
    .badge {
        padding: 0.45rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
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

    .badge.bg-secondary {
        background: var(--bg-content) !important;
        color: var(--text-secondary) !important;
        border: 1px solid var(--border-color);
    }

    /* Kegiatan Section */
    .kegiatan-section {
        margin-top: 2.5rem;
    }

    .kegiatan-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .kegiatan-title i {
        color: var(--primary);
        font-size: 1.25rem;
    }

    .kegiatan-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }

    .kegiatan-table tbody tr {
        border-bottom: 1px solid var(--border-color);
    }

    .kegiatan-table tbody tr:last-child {
        border-bottom: none;
    }

    .kegiatan-table td {
        padding: 1rem;
        color: var(--text-primary);
        font-size: 0.9375rem;
        vertical-align: middle;
    }

    .kegiatan-table td:first-child {
        width: 40px;
        text-align: center;
        color: #10b981;
    }

    .kegiatan-table td:nth-child(2) {
        font-weight: 600;
    }

    .kegiatan-table td:last-child {
        color: var(--text-secondary);
        font-style: italic;
    }

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

    /* Audit Info */
    .audit-section {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .audit-info {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.8;
    }

    .audit-info strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    .audit-info i {
        margin-right: 0.25rem;
    }

    /* Action Buttons */
    .action-section {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        flex-wrap: wrap;
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

    .btn-info {
        background: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
    }

    .btn-info:hover {
        background: #0284c7;
        border-color: #0284c7;
    }

    /* Print Styles */
    @media print {
        body {
            background: white !important;
        }
        .detail-container {
            border: none !important;
            box-shadow: none !important;
        }
        .d-print-none {
            display: none !important;
        }
        .badge {
            border: 1px solid #dee2e6 !important;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-header {
            flex-direction: column;
            text-align: center;
        }

        .program-grid {
            grid-template-columns: 1fr;
        }

        .info-table th {
            width: 140px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <h4>
                <i class="bi bi-person-vcard-fill"></i>
                Detail Warga: {{ $warga->nama }}
            </h4>
            <div class="detail-actions d-print-none">
                <a href="{{ route('data_warga.print', $warga) }}" 
                target="_blank"
                class="btn btn-danger">
                    <i class="bi bi-printer"></i> Cetak Resmi
                </a>
                <a href="{{ route('data_warga.index') }}" 
                   class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Content Body -->
        <div class="detail-body">
            <div class="row g-4">
                <!-- Identitas -->
                <div class="col-lg-6">
                    <div class="section-card identitas">
                        <h5 class="section-title">
                            <i class="bi bi-person-badge-fill"></i>
                            Identitas
                        </h5>
                        <table class="info-table">
                            <tr>
                                <th>No Registrasi</th>
                                <td>: {{ $warga->no_registrasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No KTP</th>
                                <td>: {{ $warga->no_ktp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>: <strong>{{ $warga->nama }}</strong></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>: {{ $warga->jabatan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: {{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>: {{ $warga->tempat_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>: {{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Sosial -->
                <div class="col-lg-6">
                    <div class="section-card sosial">
                        <h5 class="section-title">
                            <i class="bi bi-people-fill"></i>
                            Data Sosial
                        </h5>
                        <table class="info-table">
                            <tr>
                                <th>Status Perkawinan</th>
                                <td>: {{ $warga->statusPerkawinan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>: {{ $warga->agama->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td>: {{ $warga->pendidikan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>: {{ $warga->pekerjaan->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Kebutuhan Khusus -->
                    <div class="kebutuhan-box">
                        <h5 class="kebutuhan-title">
                            <i class="bi bi-heart-pulse-fill"></i>
                            Kebutuhan Khusus
                        </h5>
                        <div class="kebutuhan-status">
                            @if($warga->kebutuhanKhusus)
                                <span class="badge bg-danger">
                                    {{ $warga->kebutuhanKhusus->nama }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Tidak Ada / Normal
                                </span>
                            @endif
                        </div>
                        <p class="kebutuhan-desc">
                            @if($warga->kebutuhanKhusus)
                                Warga ini memiliki kebutuhan khusus yang perlu diperhatikan dalam program pemberdayaan.
                            @else
                                Warga tidak memiliki kebutuhan khusus.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Program Pemberdayaan -->
                <div class="col-12">
                    <div class="program-section">
                        <h5 class="program-title">
                            <i class="bi bi-graph-up-arrow"></i>
                            Program Pemberdayaan
                        </h5>
                        <div class="program-grid">
                            <div class="program-item">
                                <div class="program-label">Ikut PAUD</div>
                                <span class="badge bg-{{ $warga->ikut_paud == 'ya' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($warga->ikut_paud ?? 'Tidak') }}
                                </span>
                            </div>

                            <div class="program-item">
                                <div class="program-label">Kelompok Belajar</div>
                                <span class="badge bg-{{ $warga->ikut_kelompok_belajar == 'ya' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($warga->ikut_kelompok_belajar ?? 'Tidak') }}
                                </span>
                                @if($warga->ikut_kelompok_belajar == 'ya')
                                    <div class="program-detail">{{ $warga->jenisKelompokBelajar->nama ?? '-' }}</div>
                                @endif
                            </div>

                            <div class="program-item">
                                <div class="program-label">Akseptor KB</div>
                                <span class="badge bg-{{ $warga->ikut_akseptor_kb == 'ya' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($warga->ikut_akseptor_kb ?? 'Tidak') }}
                                </span>
                                @if($warga->ikut_akseptor_kb == 'ya')
                                    <div class="program-detail">{{ $warga->jenisAkseptorKb->nama ?? '-' }}</div>
                                @endif
                            </div>

                            <div class="program-item">
                                <div class="program-label">Ikut Koperasi</div>
                                <span class="badge bg-{{ $warga->ikut_koperasi == 'ya' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($warga->ikut_koperasi ?? 'Tidak') }}
                                </span>
                                @if($warga->ikut_koperasi == 'ya')
                                    <div class="program-detail">{{ $warga->jenisKoperasi->nama ?? '-' }}</div>
                                @endif
                            </div>

                            <div class="program-item">
                                <div class="program-label">Memiliki Tabungan</div>
                                <span class="badge bg-{{ $warga->memiliki_tabungan == 'ya' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($warga->memiliki_tabungan ?? 'Tidak') }}
                                </span>
                            </div>

                            <div class="program-item">
                                <div class="program-label">Status</div>
                                <span class="badge bg-{{ $warga->active ? 'success' : 'danger' }}">
                                    {{ $warga->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan Warga -->
                <div class="col-12">
                    <div class="kegiatan-section">
                        <h5 class="kegiatan-title">
                            <i class="bi bi-list-check"></i>
                            Kegiatan yang Diikuti
                        </h5>
                        @if($warga->kegiatanWarga->count() > 0)
                            <table class="kegiatan-table">
                                <tbody>
                                    @foreach($warga->kegiatanWarga as $keg)
                                        <tr>
                                            <td>
                                                <i class="bi bi-check-circle-fill"></i>
                                            </td>
                                            <td>{{ $keg->refKegiatan->nama }}</td>
                                            <td>
                                                @if($keg->keterangan){{ $keg->keterangan }}@endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada kegiatan yang diikuti</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Audit Trail -->
                <div class="col-12">
                    <div class="audit-section">
                        <div class="audit-info">
                            <p>
                                <i class="bi bi-person-plus"></i>
                                Dibuat oleh: <strong>{{ $warga->createdBy->name ?? '-' }}</strong>
                                pada {{ $warga->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                            <p>
                                <i class="bi bi-pencil"></i>
                                Terakhir diperbarui oleh: <strong>{{ $warga->updatedBy->name ?? '-' }}</strong>
                                pada {{ $warga->updated_at?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 d-print-none">
                    <div class="action-section">
                        @canany(['Admin', 'Kader', 'Pengurus'])
                            <a href="{{ route('data_warga.edit', $warga->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('kegiatan_warga.index', $warga->id) }}" class="btn btn-info">
                                <i class="bi bi-calendar-check"></i> Kegiatan Warga
                            </a>
                        @endcanany
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection