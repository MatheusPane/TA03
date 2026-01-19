@extends('layouts.layout')

@section('title', 'Sub Kegiatan Warga')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Sub Kegiatan Warga</h5>
        <a href="{{ route('kegiatan-warga-detail.create') }}"
           class="btn btn-primary btn-sm">
            + Tambah
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Warga</th>
                    <th>Kegiatan</th>
                    <th>Sub Kegiatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->warga->nama }}</td>
                    <td>{{ $row->refKegiatan->nama }}</td>
                    <td>
                        @foreach($row->detail as $d)
                            <span class="badge bg-info">
                                {{ $d->jenisKader->nama }}
                            </span>
                        @endforeach
                    </td>

                    <td>
                        <a href="{{ route('kegiatan-warga-detail.edit', $row->id) }}"
                           class="btn btn-warning btn-sm">
                           Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
