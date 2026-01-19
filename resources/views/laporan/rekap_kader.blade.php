@extends('layouts.layout')

@section('title', 'Rekapitulasi Kader PKK')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Rekapitulasi Kader PKK Tahun {{ $tahun }}</h5>
    </div>

    <div class="card-body">

        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="number"
                           name="tahun"
                           value="{{ $tahun }}"
                           class="form-control"
                           placeholder="Tahun">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Tampilkan
                    </button>
                </div>
            </div>
        </form>

        @foreach($data as $kegiatan)
            <h6 class="mt-4">
                {{ strtoupper($kegiatan->nama) }}
            </h6>

            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px">No</th>
                        <th>Jenis Kader</th>
                        <th>Dusun</th>
                        <th>Jumlah Kader</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($kegiatan->jenisKader as $jenis)
                        @php
                            $groupDusun = $jenis->kader
                                ->where('tahun', $tahun)
                                ->groupBy(fn($k) => optional($k->dusun)->nama);
                        @endphp

                        @foreach($groupDusun as $dusun => $items)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $jenis->nama }}</td>
                            <td>{{ $dusun ?? '-' }}</td>
                            <td class="text-center">{{ $items->count() }}</td>
                        </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        @endforeach

    </div>
</div>
@endsection
