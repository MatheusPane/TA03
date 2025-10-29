@extends('layouts.layout')

@section('title', 'Detail Warga: ' . $warga->nama)

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                <i class="bi bi-person-vcard"></i> Detail Warga
            </h4>
            <a href="{{ route('data_warga.index') }}" class="btn btn-light" style="border-radius: 10px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <!-- Identitas Utama -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="bi bi-person-badge"></i> Identitas</h5>
                            <table class="table table-borderless">
                                <tr><td><strong>No Registrasi</strong></td><td>: {{ $warga->no_registrasi ?? '-' }}</td></tr>
                                <tr><td><strong>No KTP</strong></td><td>: {{ $warga->no_ktp ?? '-' }}</td></tr>
                                <tr><td><strong>Nama Lengkap</strong></td><td>: <strong>{{ $warga->nama }}</strong></td></tr>
                                <tr><td><strong>Jabatan</strong></td><td>: {{ $warga->jabatan->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Jenis Kelamin</strong></td><td>: {{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                                <tr><td><strong>Tempat Lahir</strong></td><td>: {{ $warga->tempat_lahir ?? '-' }}</td></tr>
                                <tr><td><strong>Tanggal Lahir</strong></td><td>: {{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d F Y') : '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Data Sosial -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="bi bi-people"></i> Data Sosial</h5>
                            <table class="table table-borderless">
                                <tr><td><strong>Status Perkawinan</strong></td><td>: {{ $warga->statusPerkawinan->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Agama</strong></td><td>: {{ $warga->agama->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Pendidikan</strong></td><td>: {{ $warga->pendidikan->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Pekerjaan</strong></td><td>: {{ $warga->pekerjaan->nama ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Program Pemberdayaan -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-info"><i class="bi bi-graph-up"></i> Program Pemberdayaan</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Ikut PAUD</strong><br>
                                    <span class="badge bg-{{ $warga->ikut_paud == 'ya' ? 'success' : 'secondary' }} mt-1">
                                        {{ ucfirst($warga->ikut_paud) }}
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Kelompok Belajar</strong><br>
                                    <span class="badge bg-{{ $warga->ikut_kelompok_belajar == 'ya' ? 'success' : 'secondary' }} mt-1">
                                        {{ ucfirst($warga->ikut_kelompok_belajar) }}
                                    </span>
                                    @if($warga->ikut_kelompok_belajar == 'ya')
                                        <br><small class="text-muted">{{ $warga->jenisKelompokBelajar->nama ?? '-' }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <strong>Akseptor KB</strong><br>
                                    <span class="badge bg-{{ $warga->ikut_akseptor_kb == 'ya' ? 'success' : 'secondary' }} mt-1">
                                        {{ ucfirst($warga->ikut_akseptor_kb) }}
                                    </span>
                                    @if($warga->ikut_akseptor_kb == 'ya')
                                        <br><small class="text-muted">{{ $warga->jenisAkseptorKb->nama ?? '-' }}</small>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <strong>Ikut Koperasi</strong><br>
                                    <span class="badge bg-{{ $warga->ikut_koperasi == 'ya' ? 'success' : 'secondary' }} mt-1">
                                        {{ ucfirst($warga->ikut_koperasi) }}
                                    </span>
                                    @if($warga->ikut_koperasi == 'ya')
                                        <br><small class="text-muted">{{ $warga->jenisKoperasi->nama ?? '-' }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <strong>Memiliki Tabungan</strong><br>
                                    <span class="badge bg-{{ $warga->memiliki_tabungan == 'ya' ? 'success' : 'secondary' }} mt-1">
                                        {{ ucfirst($warga->memiliki_tabungan) }}
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Status Aktif</strong><br>
                                    <span class="badge bg-{{ $warga->active ? 'success' : 'danger' }} mt-1">
                                        {{ $warga->active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Audit Trail -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-secondary"><i class="bi bi-clock-history"></i> Riwayat</h5>
                            <small class="text-muted">
                                Dibuat oleh: <strong>{{ $warga->createdBy->name ?? '-' }}</strong>
                                pada {{ $warga->created_at ? \Carbon\Carbon::parse($warga->created_at)->format('d/m/Y H:i') : '-' }}
                                <br>
                                Diperbarui oleh: <strong>{{ $warga->updatedBy->name ?? '-' }}</strong>
                                pada {{ $warga->updated_at ? \Carbon\Carbon::parse($warga->updated_at)->format('d/m/Y H:i') : '-' }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Aksi -->
                <div class="col-md-12 text-end mt-3">
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
                        <a href="{{ route('data_warga.edit', $warga->id) }}" class="btn btn-warning" style="border-radius: 10px;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    @endif
                    <a href="{{ route('data_warga.index') }}" class="btn btn-secondary" style="border-radius: 10px;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 