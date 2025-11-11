{{-- resources/views/surat_tugas/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Surat Tugas')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Detail Surat Tugas</h4>
            <div>
                <a href="{{ route('surat-tugas.edit', $suratTuga) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('surat-tugas.cetak', $suratTuga) }}" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Nomor Surat</th><td><strong>{{ $suratTuga->nomor }}</strong></td></tr>
                    <tr><th>Dikeluarkan di</th><td>{{ $suratTuga->dusun?->nama ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $suratTuga->tanggal?->format('d F Y') }}</td></tr>
                    <tr><th>Dibuat</th><td>{{ $suratTuga->created_at->format('d F Y H:i') }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Penanda Tangan</th><td>{{ $suratTuga->nama_penanda_tangan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratTuga->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- PENERIMA TUGAS -->
            <div class="col-md-6">
                <h6 class="fw-bold">Penerima Tugas:</h6>
                <table class="table table-bordered">
                    <tr><th width="120">Nama</th><td>{{ $suratTuga->penerimaTugas?->nama ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratTuga->penerimaTugas?->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <!-- PELAKSANAAN -->
            <div class="col-md-6">
                <h6 class="fw-bold">Pelaksanaan:</h6>
                <table class="table table-bordered">
                    <tr><th width="120">Hari/Tanggal</th><td>{{ $suratTuga->hari_tanggal }}</td></tr>
                    <tr><th>Waktu</th><td>{{ $suratTuga->waktu }}</td></tr>
                    <tr><th>Tempat</th><td>{{ $suratTuga->tempat }}</td></tr>
                </table>
            </div>

            <!-- DASAR -->
            @if($suratTuga->dasar && count($suratTuga->dasar))
            <div class="col-12">
                <h6 class="fw-bold">Dasar:</h6>
                <ol>
                    @foreach($suratTuga->dasar as $d)
                        @if($d)<li>{{ $d }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif

            <!-- UNTUK -->
            <div class="col-12">
                <h6 class="fw-bold">Untuk:</h6>
                <div class="p-3 bg-light rounded">{!! nl2br(e($suratTuga->untuk)) !!}</div>
            </div>

            <!-- TEMBUSAN -->
            @if($suratTuga->tembusan && count($suratTuga->tembusan))
            <div class="col-12">
                <h6 class="fw-bold">Tembusan:</h6>
                <ol>
                    @foreach($suratTuga->tembusan as $t)
                        @if($t)<li>Yth. {{ $t }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection