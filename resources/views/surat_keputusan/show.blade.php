{{-- resources/views/surat_keputusan/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Surat Keputusan')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">
                Detail Surat Keputusan
            </h4>
            <div>
                <a href="{{ route('surat_keputusan.edit', $suratKeputusan) }}" class="btn btn-warning btn-sm">
                    Edit
                </a>
                <a href="{{ route('surat_keputusan.cetak', $suratKeputusan) }}" target="_blank" class="btn btn-success btn-sm">
                    Cetak PDF
                </a>
                <a href="{{ route('surat_keputusan.index') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Nomor</th><td><strong>{{ $suratKeputusan->nomor }}</strong></td></tr>
                    <tr><th>Tentang</th><td>{{ $suratKeputusan->tentang }}</td></tr>
                    <tr><th>Ditetapkan di</th><td>{{ $suratKeputusan->ditetapkan_di }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $suratKeputusan->tanggal->format('d F Y') }}</td></tr>
                    <tr><th>Dibuat oleh</th><td>{{ $suratKeputusan->creator?->name ?? '-' }}</td></tr>
                    <tr><th>Diperbarui oleh</th><td>{{ $suratKeputusan->updater?->name ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Penanda Tangan</th><td>{{ $suratKeputusan->nama_penanda_tangan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratKeputusan->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- MENIMBANG -->
            @if($suratKeputusan->menimbang)
            <div class="col-12">
                <h6 class="fw-bold">Menimbang:</h6>
                <p class="ms-3">{!! nl2br(e($suratKeputusan->menimbang)) !!}</p>
            </div>
            @endif

            <!-- MENGINGAT -->
            @if($suratKeputusan->mengingat && count($suratKeputusan->mengingat))
            <div class="col-12">
                <h6 class="fw-bold">Mengingat:</h6>
                <ol class="ms-3">
                    @foreach($suratKeputusan->mengingat as $poin)
                        @if($poin)<li>{{ $poin }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif

            <!-- MEMPERHATIKAN -->
            @if($suratKeputusan->memperhatikan)
            <div class="col-12">
                <h6 class="fw-bold">Memperhatikan:</h6>
                <p class="ms-3">{!! nl2br(e($suratKeputusan->memperhatikan)) !!}</p>
            </div>
            @endif

            <!-- MENETAPKAN -->
            <div class="col-12">
                <h6 class="fw-bold">Menetapkan:</h6>
                @foreach(['PERTAMA', 'KEDUA', 'KETIGA'] as $key)
                    @if(isset($suratKeputusan->menetapkan[$key]) && $suratKeputusan->menetapkan[$key])
                        <p class="ms-3"><strong>{{ $key }}:</strong><br>{!! nl2br(e($suratKeputusan->menetapkan[$key])) !!}</p>
                    @endif
                @endforeach
            </div>

            <!-- TEMBUSAN -->
            @if($suratKeputusan->tembusan && count($suratKeputusan->tembusan))
            <div class="col-12">
                <h6 class="fw-bold">Tembusan:</h6>
                <ol>
                    @foreach($suratKeputusan->tembusan as $t)
                        @if($t)<li>{{ $t }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection