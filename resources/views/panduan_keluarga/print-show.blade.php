<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Catatan Keluarga - {{ $kepala?->nama ?? 'Keluarga' }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9px; margin: 15px; line-height: 1.3; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 3px; }
        th { background: #f0f0f0; text-align: center; font-weight: bold; }
        .no-border td, .no-border th { border: none; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-3 { margin-bottom: 15px; }
        .header { margin-bottom: 20px; }
        .left { float: left; width: 75%; }
        .right { float: right; width: 24%; }
        .clearfix::after { content: ""; clear: both; display: table; }
        @page { size: A4; margin: 1cm; }
    </style>
</head>
<body>

<div class="header text-center">
    <h2><strong>CATATAN KELUARGA</strong></h2>
</div>

@php
    $detail = $keluarga->detail;
    $kepala = $keluarga->anggotaKeluarga
        ->firstWhere(fn($a) => $a->statusDalamKeluarga && str_contains(strtolower($a->statusDalamKeluarga->nama), 'kepala'))
        ?->warga;
@endphp

<div class="clearfix">
    <div class="left">
        <table class="no-border">
            <tr>
                <td width="150">CATATAN KELUARGA DARI</td>
                <td width="10">:</td>
                <td><strong>{{ $kepala?->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>ANGGOTA KELOMPOK DASAWISMA</td>
                <td>:</td>
                <td><strong>{{ $keluarga->dasawisma?->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>TAHUN</td>
                <td>:</td>
                <td><strong>{{ now()->year }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="right">
        <table class="no-border">
            <tr>
                <td width="120">KRITERIA RUMAH</td>
                <td width="10">:</td>
                <td>{{ $detail?->kriteria_rumah == 'Sehat' ? 'Layak Huni' : 'Tidak Layak Huni' }}</td>
            </tr>
            <tr>
                <td>JAMBAN KELUARGA</td>
                <td>:</td>
                <td>{{ $detail?->punya_jamban ? 'Ada' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>SUMBER AIR</td>
                <td>:</td>
                <td>{{ $detail?->sumberAir?->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>TEMPAT SAMPAH</td>
                <td>:</td>
                <td>{{ $detail?->punya_tempat_sampah ? 'Ada' : 'Tidak' }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="clearfix mb-3"></div>

<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>NAMA Anggota Keluarga</th>
            <th>STATUS PERKAWINAN</th>
            <th>L/P</th>
            <th>TEMPAT LAHIR</th>
            <th>TGL/BL/TH LAHIR<br>/UMUR</th>
            <th>AGAMA</th>
            <th>PENDIDIKAN</th>
            <th>PEKERJAAN</th>
            <th>KEBUTUHAN KHUSUS</th>
            <th>KEGIATAN PKK<br>(yang diikuti)</th>
        </tr>
        <tr>
            <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
        </tr>
    </thead>
    <tbody>
        @foreach($keluarga->anggotaKeluarga as $anggota)
            @php
                $w = $anggota->warga;
                $umur = $w?->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->age : '-';
                $kegiatan = $w?->kegiatanWarga->where('ikut', true)->pluck('refKegiatan.nama')->implode(', ');
                $isKepala = $anggota->statusDalamKeluarga && str_contains(strtolower($anggota->statusDalamKeluarga->nama), 'kepala');
            @endphp
            <tr {{ $isKepala ? 'style="font-weight:bold; background:#f0f8ff;"' : '' }}>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $w?->nama ?? '-' }} {{ $isKepala ? ' (KRT)' : '' }}</td>
                <td class="text-center">{{ $w?->statusPerkawinan?->nama ?? '-' }}</td>
                <td class="text-center">{{ $w?->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                <td>{{ $w?->tempat_lahir ?? '-' }}</td>
                <td class="text-center">
                    {{ $w?->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->format('d-m-Y') : '-' }}<br>
                    <small>{{ $umur }} thn</small>
                </td>
                <td class="text-center">{{ $w?->agama?->nama ?? '-' }}</td>
                <td class="text-center">{{ $w?->pendidikan?->nama ?? '-' }}</td>
                <td class="text-center">{{ $w?->pekerjaan?->nama ?? '-' }}</td>
                <td class="text-center">{{ $w?->kebutuhanKhusus?->nama ?? '-' }}</td>            
                <td style="font-size:8px;">{{ $kegiatan ?: '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:60px; float:right; text-align:center;">
    <p>______________, {{ now()->format('d F Y') }}</p>
    <p>Ketua Kelompok Dasawisma</p>
    <br><br><br>
    <p><strong>(_____________________________)</strong></p>
</div>

</body>
</html>