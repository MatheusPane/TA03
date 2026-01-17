<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LAMPIRAN - BUKU INVENTARIS DESA</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .container {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 1.8cm 1.5cm 1cm;
            background: white;
        }
        .text-center { text-align: center; }
        h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        h3 { margin: 8px 0 25px; font-size: 14pt; font-weight: bold; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            border: 2px solid #000; 
            margin-bottom: 40px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 6px 8px; 
            vertical-align: middle; 
            text-align: left; 
        }
        th { 
            text-align: center; 
            font-weight: bold; 
            background: #f0f0f0; 
        }
        .col-no { width: 40px; text-align: center; }
        .col-nama { width: 20%; }
        .col-asal { width: 15%; }
        .col-tanggal { width: 14%; text-align: center; }
        .col-jumlah { width: 10%; text-align: center; }
        .col-tempat { width: 15%; }
        .col-kondisi { width: 12%; text-align: center; }
        .col-ket { width: auto; }
        .header-row th { font-size: 10pt; padding: 4px; }
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            text-align: center;
            color: #555;
        }
        .page-break { page-break-after: always; }
        @media print {
            body { background: white; }
            .container { box-shadow: none; margin: 0; padding: 1.8cm 1.5cm 1cm; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center">
        <h2>BUKU INVENTARIS DESA</h2>
        <h3>LAMPIRAN BUKU INVENTARIS</h3>
        <p style="margin: 5px 0 20px;">Desa/Kelurahan {{ config('app.nama_desa', 'Silalahi Dolok') }} - Tahun {{ now()->year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">NO</th>
                <th class="col-nama">NAMA BARANG</th>
                <th class="col-asal">ASAL BARANG</th>
                <th class="col-tanggal">TANGGAL<br>PENERIMAAN / PEMBELIAN</th>
                <th class="col-jumlah">JUMLAH</th>
                <th class="col-tempat">TEMPAT<br>PENYIMPANAN</th>
                <th class="col-kondisi">KONDISI<br>BARANG</th>
                <th class="col-ket">KETERANGAN</th>
            </tr>
            <tr class="header-row">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $item)
                <tr>
                    <td class="col-no">{{ $loop->iteration }}</td>
                    <td class="col-nama">{{ $item->nama_barang }}</td>
                    <td class="col-asal">{{ $item->asal_barang }}</td>
                    <td class="col-tanggal">{{ $item->tanggal_pembelian ? $item->tanggal_pembelian->format('d-m-Y') : '-' }}</td>
                    <td class="col-jumlah">{{ $item->jumlah }}</td>
                    <td class="col-tempat">{{ $item->tempat_penyimpanan }}</td>
                    <td class="col-kondisi">{{ $item->kondisi_barang }}</td>
                    <td class="col-ket">{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 100px 0;">
                        Tidak ada data inventaris untuk dicetak.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Printed from Sistem Dasawisma PKK • {{ now()->format('d F Y H:i') }}</p>
        <p>© {{ now()->year }} PKK Desa/Kelurahan {{ config('app.nama_desa', 'Silalahi Dolok') }}</p>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>