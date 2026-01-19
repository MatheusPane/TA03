<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi PKK</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>

<button onclick="window.print()">🖨 Print</button>

<h3 style="text-align:center">DATA KEGIATAN PKK</h3>

<table>
    <tr>
        <th rowspan="3">NAMA WILAYAH<br>(DUSUN)</th>

        <th colspan="3">JUMLAH KADER</th>

        <th colspan="4">PENGHAYATAN DAN PENGAMALAN PANCASILA</th>

        <th colspan="5">GOTONG ROYONG<br>(JUMLAH ANGGOTA)</th>
    </tr>

    <tr>
        <th>PKBN</th>
        <th>PKDRT</th>
        <th>POLA ASUH</th>

        <th>PKBN</th>
        <th>PKDRT</th>
        <th>POLA ASUH</th>
        <th>LANSIA</th>

        <th>KERJA BAKTI</th>
        <th>RUKUN KEMATIAN</th>
        <th>KEAGAMAAN</th>
        <th>JIMPITAN</th>
        <th>ARISAN</th>
    </tr>

    <tr>
        <th colspan="3">JUMLAH KADER</th>
        <th colspan="4">JUMLAH ANGGOTA</th>
        <th colspan="5">JUMLAH ANGGOTA</th>
    </tr>

    @foreach($wilayah as $w)
    <tr>
        <td>{{ $w->nama_wilayah }}</td>

        {{-- JUMLAH KADER --}}
        <td>{{ $w->kader_pkbn }}</td>
        <td>{{ $w->kader_pkdrt }}</td>
        <td>{{ $w->kader_pola_asuh }}</td>

        {{-- PANCASILA --}}
        <td>{{ $w->anggota_pkbn }}</td>
        <td>{{ $w->anggota_pkdrt }}</td>
        <td>{{ $w->anggota_pola_asuh }}</td>
        <td>{{ $w->anggota_lansia }}</td>

        {{-- GOTONG ROYONG --}}
        <td>{{ $w->kerja_bakti }}</td>
        <td>{{ $w->rukun_kematian }}</td>
        <td>{{ $w->keagamaan }}</td>
        <td>{{ $w->jimpitan }}</td>
        <td>{{ $w->arisan }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
