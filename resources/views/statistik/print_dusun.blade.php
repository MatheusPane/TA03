<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DATA UMUM PKK</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }
    
        .container {
            width: 100%;
            max-width: 29.7cm;
            margin: 0 auto;
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }
    
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
    
        th {
            font-weight: bold;
        }
    
        .text-left {
            text-align: left;
        }
    
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
    
        @media print {
            body {
                margin: 0;
                font-size: 9pt;
            }
    
            th, td {
                padding: 3px;
            }
        }
        .header-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .header-info {
            text-align: left;
            margin-bottom: 15px;
        }
        .info-line {
    font-size: 11pt;
    line-height: 1.5;
}

.info-line .label {
    display: inline-block;
    width: 160px;      /* KUNCI lebar label */
}

.info-line .colon {
    display: inline-block;
    width: 10px;
    text-align: center;
}

.info-line .value {
    display: inline-block;
}


    </style>
    
</head>
<body>

<div class="container">

    <div class="header-title">
        <h2>DATA UMUM PKK</h2>
    </div>
    
    <div class="header-info">
        <div class="info-line">
            <span class="label">Desa/Kelurahan</span>
            <span class="colon">:</span>
            <span class="value">{{ $namaDesa }}</span>
        </div>
        <div class="info-line">
            <span class="label">Kecamatan</span>
            <span class="colon">:</span>
            <span class="value">{{ $kecamatan }}</span>
        </div>
        <div class="info-line">
            <span class="label">Kabupaten</span>
            <span class="colon">:</span>
            <span class="value">{{ $kabupaten }}</span>
        </div>
        <div class="info-line">
            <span class="label">Provinsi</span>
            <span class="colon">:</span>
            <span class="value">{{ $provinsi }}</span>
        </div>
        <div class="info-line">
            <span class="label">Tahun</span>
            <span class="colon">:</span>
            <span class="value">{{ $tahun }}</span>
        </div>
        
    </div>    

    <table>
        <thead>
            <tr>
                <th rowspan="3">NO</th>
                <th rowspan="3">NAMA DUSUN</th>
                <th rowspan="3">JUMLAH DASAWISMA</th>
                <th rowspan="3">JUMLAH KK</th>
    
                <th colspan="2">JUMLAH JIWA</th>
                <th rowspan="3">JUMLAH</th>
    
                <th colspan="6">JUMLAH KADER</th>
                <th colspan="4">JUMLAH TENAGA SEKRETARIAT</th>
            </tr>
    
            <tr>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
    
                <th colspan="2">ANGGOTA TP PKK</th>
                <th colspan="2">UMUM</th>
                <th colspan="2">KHUSUS</th>
    
                <th colspan="2">HONORER</th>
                <th colspan="2">BANTUAN</th>
            </tr>
    
            <tr>
                <th>L</th>
                <th>P</th>
                <th>L</th>
                <th>P</th>
                <th>L</th>
                <th>P</th>
    
                <th>L</th>
                <th>P</th>
                <th>L</th>
                <th>P</th>
            </tr>
        </thead>
    
        <tbody>
            @foreach($statistik as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">{{ $row->nama_dusun }}</td>
                <td>{{ $row->jumlah_dasawisma }}</td>
                <td>{{ $row->jumlah_kk }}</td>
    
                <td>{{ $row->jumlah_laki }}</td>
                <td>{{ $row->jumlah_perempuan }}</td>
                <td>{{ $row->jumlah_laki + $row->jumlah_perempuan }}</td>
    
                {{-- JUMLAH KADER (KOSONG – ISI MANUAL) --}}
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
    
                {{-- TENAGA SEKRETARIAT (KOSONG – ISI MANUAL) --}}
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
