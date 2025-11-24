<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LAMPIRAN 4.14.1a - Data Warga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11.5px;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f5f5f5;
        }
        .container {
            background: white;
            width: 21cm;
            min-height: 29.7cm;
            padding: 1.8cm 1.5cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .text-center { text-align: center; }
        .underline { 
            border-bottom: 1px solid #000; 
            display: inline-block; 
            min-width: 280px; 
            padding: 0 5px; 
        }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px 0; vertical-align: top; }
        .checkbox {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 2px solid #000;
            margin: 0 8px 0 15px;
            vertical-align: middle;
            position: relative;
        }
        .checked::after {
            content: "X";
            position: absolute;
            top: -4px;
            left: 0;
            font-weight: bold;
            font-size: 14px;
            width: 100%;
            text-align: center;
        }
        .section { margin: 18px 0; }
        @media print {
            body { background: white; }
            .container { box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center">
        <h2 style="margin:0; font-size:16px;"><strong>DATA WARGA TP PKK</strong></h2>
        <h3 style="margin:8px 0 25px; font-size:14px;">LAMPIRAN 4.14.1a</h3>
    </div>

    <div class="section">
        <table>
            <tr>
                <td width="25">1.</td>
                <td width="170">No. Registrasi</td>
                <td>: <span class="underline">11</span></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>No. KTP/NIK</td>
                <td>: <span class="underline">1234567889</span></td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Nama</td>
                <td>: <strong>firmanti_pane</strong></td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Jenis Kelamin</td>
                <td>:
                    <span class="checkbox checked"></span> Laki-laki
                    <span class="checkbox"></span> Perempuan
                </td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Tempat Lahir</td>
                <td>: <span class="underline">AekNatolu</span></td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Tanggal Lahir</td>
                <td>: <span class="underline">09-05-2005</span></td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Umur</td>
                <td>: <span class="underline">20 tahun</span></td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Status Perkawinan</td>
                <td>:
                    <span class="checkbox checked"></span> Kawin
                </td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Agama</td>
                <td>:
                    <span class="checkbox checked"></span> Kristen Protestan
                </td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Kebutuhan Khusus</td>
                <td>:
                    <span class="checkbox"></span> Tidak Ada
                </td>
            </tr>
            <tr>
                <td>11.</td>
                <td>Pendidikan</td>
                <td>:
                    <span class="checkbox checked"></span> Diploma
                </td>
            </tr>
            <tr>
                <td>12.</td>
                <td>Pekerjaan</td>
                <td>:
                    <span class="checkbox checked"></span> PNS
                </td>
            </tr>
            <tr>
                <td>13.</td>
                <td>Akseptor KB</td>
                <td>:
                    <span class="checkbox checked"></span> Ya
                    <span class="checkbox"></span> Tidak
                    <em>Jenis Akseptor KB:</em> <u>Paket A</u>
                </td>
            </tr>
            <tr>
                <td>14.</td>
                <td>Memiliki Tabungan</td>
                <td>:
                    <span class="checkbox checked"></span> Ya
                    <span class="checkbox"></span> Tidak
                </td>
            </tr>
            <tr>
                <td>15.</td>
                <td>Mengikuti Kelompok Belajar</td>
                <td>:
                    <span class="checkbox checked"></span> Ya
                    <span class="checkbox"></span> Tidak
                    <em>Jenis Kelompok Belajar:</em> <u>Paket A</u>
                </td>
            </tr>
            <tr>
                <td>16.</td>
                <td>Mengikuti PAUD</td>
                <td>:
                    <span class="checkbox checked"></span> Ya
                    <span class="checkbox"></span> Tidak
                </td>
            </tr>
            <tr>
                <td>17.</td>
                <td>Ikut dalam Kegiatan Koperasi</td>
                <td>:
                    <span class="checkbox checked"></span> Ya
                    <span class="checkbox"></span> Tidak
                    <em>Jenis Koperasi:</em> <u>Mawar Koperasi</u>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>