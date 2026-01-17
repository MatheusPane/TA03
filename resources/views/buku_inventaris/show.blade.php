@extends('layouts.layout')

@section('title', 'Detail Barang Inventaris')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <!-- HEADER -->
        <div class="card-header bg-primary bg-gradient text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0 fw-bold">Detail Barang: {{ $barang->nama_barang }}</h4>
                </div>
                <div class="col-auto">
                    <a href="{{ route('buku-inventaris.index') }}" class="btn btn-outline-light btn-sm me-2">
                        ← Kembali
                    </a>
                    @if(Auth::user()->hasRole(['Admin', 'Kader', 'Pengurus']))
                        <a href="{{ route('buku-inventaris.edit', $barang->id) }}" 
                           class="btn btn-warning btn-sm d-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-pencil-fill"></i>
                            Edit Barang
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

            <div class="row g-4">
                <!-- Info Utama -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Informasi Barang</h5>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">Nama Barang</dt>
                                <dd class="col-sm-8 fw-medium">{{ $barang->nama_barang }}</dd>

                                <dt class="col-sm-4 text-muted">Asal Barang</dt>
                                <dd class="col-sm-8">{{ $barang->asal_barang }}</dd>

                                <dt class="col-sm-4 text-muted">Tanggal Pembelian</dt>
                                <dd class="col-sm-8">{{ $barang->tanggal_pembelian ? $barang->tanggal_pembelian->format('d F Y') : '-' }}</dd>

                                <dt class="col-sm-4 text-muted">Jumlah</dt>
                                <dd class="col-sm-8">{{ $barang->jumlah }} unit</dd>

                                <dt class="col-sm-4 text-muted">Tempat Penyimpanan</dt>
                                <dd class="col-sm-8">{{ $barang->tempat_penyimpanan }}</dd>

                                <dt class="col-sm-4 text-muted">Kondisi Saat Ini</dt>
                                <dd class="col-sm-8">
                                    <span class="badge rounded-pill {{ $barang->kondisi_barang == 'Baik' ? 'bg-success' : ($barang->kondisi_barang == 'Cukup Baik' ? 'bg-info' : 'bg-danger') }} px-3 py-2">
                                        {{ $barang->kondisi_barang }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4 text-muted">Keterangan</dt>
                                <dd class="col-sm-8">{{ $barang->keterangan ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Info Audit & Riwayat -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">Riwayat & Pembuat</h5>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">Dibuat Oleh</dt>
                                <dd class="col-sm-8">{{ $barang->createdBy->name ?? 'Sistem' }} <small class="text-muted">({{ $barang->created_at->format('d/m/Y H:i') }})</small></dd>

                                <dt class="col-sm-4 text-muted">Diperbarui Oleh</dt>
                                <dd class="col-sm-8">{{ $barang->updatedBy->name ?? 'Belum diupdate' }} <small class="text-muted">({{ $barang->updated_at->format('d/m/Y H:i') }})</small></dd>

                                <dt class="col-sm-4 text-muted">Status Terakhir</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-secondary">Aktif</span>
                                    <small class="text-muted ms-2">(Belum ada penghapusan)</small>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Tambahan -->
                <div class="col-12 mt-4 text-end">
                    <!-- Di dalam <div class="col-12 mt-4 text-end"> -->
                    @if(Auth::user()->hasRole('Admin'))
                        <form action="{{ route('buku-inventaris.destroy', $barang->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4" onclick="return confirm('Yakin ingin menghapus barang ini dari inventaris? Ini tidak bisa dibatalkan.')">
                                <i class="bi bi-trash-fill me-2"></i> Hapus Barang
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection