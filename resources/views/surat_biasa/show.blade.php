{{-- resources/views/surat_biasa/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Surat Biasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Detail Surat Biasa</h4>
            <div>
                <a href="{{ route('surat-biasa.edit', $suratBiasa) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('surat-biasa.cetak', $suratBiasa) }}" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                <a href="{{ route('surat-biasa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Nomor Surat</th><td><strong>{{ $suratBiasa->nomor }}</strong></td></tr>
                    <tr><th>Lampiran</th><td>{{ $suratBiasa->lampiran ?? '-' }}</td></tr>
                    <tr><th>Perihal</th><td>{{ $suratBiasa->perihal }}</td></tr>
                    <tr><th>Kepada</th><td>{{ $suratBiasa->kepada }}</td></tr>
                    <tr><th>Di</th><td>{{ $suratBiasa->di }}</td></tr>
                    <tr><th>Tanggal Surat</th><td>{{ $suratBiasa->tanggal?->format('d F Y') ?? '-' }}</td></tr>
                    <tr><th>Dibuat</th><td>{{ $suratBiasa->created_at->format('d F Y H:i') }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Penanda Tangan</th><td>{{ $suratBiasa->nama_penanda_tangan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratBiasa->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <div class="col-12">
                <h6 class="fw-bold">Kata Pembuka:</h6>
                <p class="ms-3">{!! nl2br(e($suratBiasa->kata_pembuka)) !!}</p>
            </div>

            <div class="col-12">
                <h6 class="fw-bold">Isi/Maksud Surat:</h6>
                <p class="ms-3">{!! nl2br(e($suratBiasa->isi_surat)) !!}</p>
            </div>

            <div class="col-12">
                <h6 class="fw-bold">Penutup:</h6>
                <p class="ms-3">{!! nl2br(e($suratBiasa->penutup)) !!}</p>
            </div>

            @if($suratBiasa->tembusan && count($suratBiasa->tembusan))
            <div class="col-12">
                <h6 class="fw-bold">Tembusan:</h6>
                <ol>
                    @foreach($suratBiasa->tembusan as $t)
                        @if($t)<li>{{ $t }}</li>@endif
                    @endforeach
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection