{{-- resources/views/surat_edaran/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Surat Edaran')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Detail Surat Edaran</h4>
            <div>
                <a href="{{ route('surat-edaran.edit', $suratEdaran) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('surat-edaran.cetak', $suratEdaran) }}" target="_blank" class="btn btn-success btn-sm">Cetak PDF</a>
                <a href="{{ route('surat-edaran.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Nomor Surat</th><td><strong>{{ $suratEdaran->nomor }}</strong></td></tr>
                    <tr><th>Tentang</th><td>{{ $suratEdaran->tentang }}</td></tr>
                    <tr><th>Dikeluarkan di</th><td>{{ $suratEdaran->dusun?->nama ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ $suratEdaran->tanggal?->format('d F Y') }}</td></tr>
                    <tr><th>Dibuat</th><td>{{ $suratEdaran->created_at->format('d F Y H:i') }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="180">Penanda Tangan</th><td>{{ $suratEdaran->nama_penanda_tangan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $suratEdaran->jabatan?->nama ?? '-' }}</td></tr>
                </table>
            </div>

            <div class="col-12">
                <h6 class="fw-bold">Isi Surat Edaran:</h6>
                <ol class="ms-3">
                    <li>{!! nl2br(e($suratEdaran->poin_1)) !!}</li>
                    <li>{!! nl2br(e($suratEdaran->poin_2)) !!}</li>
                    <li>{!! nl2br(e($suratEdaran->poin_3)) !!}</li>
                    <li>{!! nl2br(e($suratEdaran->poin_4)) !!}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection