{{-- resources/views/surat_kuasa/index.blade.php --}}
@extends('layouts.layout')

@section('title', 'Daftar Surat Kuasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Daftar Surat Kuasa</h4>
            <a href="{{ route('surat-kuasa.create') }}" class="btn btn-primary btn-sm">
                + Buat Surat Kuasa
            </a>
        </div>

        @if($surat->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor</th>
                        <th>Pemberi Kuasa</th>
                        <th>Penerima Kuasa</th>
                        <th>Dikeluarkan di</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat as $i => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nomor }}</strong></td>
                        <td>{{ $item->pemberiKuasa?->nama ?? '-' }}</td>
                        <td>{{ $item->penerimaKuasa?->nama ?? '-' }}</td>
                        <td>{{ $item->dusun?->nama ?? '-' }}</td>
                        <td>{{ $item->tanggal?->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('surat-kuasa.show', $item) }}" class="btn btn-info btn-sm" title="Lihat">
                                Lihat
                            </a>
                            <a href="{{ route('surat-kuasa.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                Edit
                            </a>
                            <a href="{{ route('surat-kuasa.cetak', $item) }}" target="_blank" class="btn btn-success btn-sm" title="Cetak">
                                Cetak
                            </a>
                            <form action="{{ route('surat-kuasa.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin arsipkan surat ini?')">
                                    Arsip
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            Belum ada Surat Kuasa. <a href="{{ route('surat-kuasa.create') }}">Buat sekarang</a>.
        </div>
        @endif
    </div>
</div>
@endsection