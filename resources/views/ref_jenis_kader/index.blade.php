@extends('layouts.layout')

@section('title', 'Jenis Kader')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Data Jenis Kader</h5>
        <a href="{{ route('ref-jenis-kader.create') }}" class="btn btn-primary btn-sm">
            + Tambah Jenis Kader
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Nama Jenis Kader</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jenisKader as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->kegiatan->nama }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>
                        <a href="{{ route('ref-jenis-kader.edit', $row->id) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('ref-jenis-kader.destroy', $row->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus data?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
