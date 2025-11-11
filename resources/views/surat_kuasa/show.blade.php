{{-- resources/views/surat_kuasa/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Surat Kuasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Detail Surat Kuasa</h4>
            <div>
                <a href="{{ route('surat-kuasa.edit', $suratKuasa) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('surat-kuasa.cetak', $suratKuasa) }}" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                <a href="{{ route('surat-kuasa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Nomor Surat</th><td><strong>{{ $suratKuasa->nomor }}</strong></td></tr>
                    <tr><th>Dikeluarkan di</th><td>{{ $suratKuasa->dusun?->nama ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $suratKuasa->tanggal?->format('d F Y') }}</td></tr>
                    <tr><th>Dibuat</th><td>{{ $suratKuasa->created_at->format('d F Y H:i') }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Penanda Tangan</th><td>{{ $suratKuasa->nama_penanda_tangan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratKuasa->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- PEMBERI KUASA -->
            <div class="col-md-6">
                <h6 class="fw-bold">Pemberi Kuasa:</h6>
                <table class="table table-bordered">
                    <tr><th width="120">Nama</th><td>{{ $suratKuasa->pemberiKuasa?->nama ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratKuasa->pemberiKuasa?->jabatan?->nama ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $suratKuasa->dusun?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- PENERIMA KUASA -->
            <div class="col-md-6">
                <h6 class="fw-bold">Penerima Kuasa:</h6>
                <table class="table table-bordered">
                    <tr><th width="120">Nama</th><td>{{ $suratKuasa->penerimaKuasa?->nama ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratKuasa->penerimaKuasa?->jabatan?->nama ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $suratKuasa->dusun?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- UNTUK -->
            <div class="col-12">
                <h6 class="fw-bold">Untuk:</h6>
                <div class="p-3 bg-light rounded">{!! nl2br(e($suratKuasa->untuk)) !!}</div>
            </div>

            <!-- TEMBUSAN -->
            @if($suratKuasa->tembusan && count($suratKuasa->tembusan))
            <div class="col-12">
                <h6 class="fw-bold">Tembusan:</h6>
                <ol>
                    @foreach($suratKuasa->tembusan as $t)
                        @if($t)<li>Yth. {{ $t }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection