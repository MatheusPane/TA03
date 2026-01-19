@extends('layouts.layout')

@section('title', 'Data Kader')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Kader</h5>
        <a href="{{ route('kader.create') }}" class="btn btn-primary btn-sm">
            + Tambah Kader
        </a>
        <a href="{{ route('laporan.rekap-kader') }}" class="btn btn-primary btn-sm">
            Cek Rekapitulasi
        </a>
    </div>

<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Warga</th>
                <th>Dusun</th>
                <th>Jenis Kader</th>
                <th>Kegiatan</th>
                <th>Tahun</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kader as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->warga->nama ?? '-' }}</td>
                <td>{{ $row->dusun->nama ?? '-' }}</td>
                <td>{{ $row->jenisKader->nama ?? '-' }}</td>
                <td>{{ $row->jenisKader->kegiatan->nama ?? '-' }}</td>
                <td>{{ $row->tahun }}</td>
                <td>
                    <a href="{{ route('kader.edit', $row->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('kader.destroy', $row->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus data kader ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">
                    Data belum tersedia
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
@endsection
