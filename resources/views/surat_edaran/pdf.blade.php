{{-- resources/views/surat_edaran/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Edaran - {{ $suratEdaran->nomor }}</title>
    <style>
        /* HILANGKAN MARGIN ATAS BODY */
        body {
            font-family: 'Times New Roman', serif;
            margin: 0.5cm 2cm 2cm 2cm; /* atas: 0.5cm (rapat), kiri/kanan/bawah: 2cm */
            font-size: 12pt;
            line-height: 1.6;
        }

        /* LOGO: DI ATAS SEKALI, TANPA MARGIN */
        .logo {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 5px; /* jarak kecil ke kop */
        }

        /* KOP: LANGSUNG DI BAWAH LOGO, TANPA JARAK BESAR */
        .kop {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-transform: uppercase;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        /* GARIS PEMBATAS: TIPIS & RAPAT */
        hr {
            border: none;
            border-top: 2px solid black;
            margin: 8px 0 15px 0;
        }

        /* JUDUL SURAT EDARAN */
        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 25px 0 15px 0;
            font-size: 13pt;
        }

        .nomor {
            text-align: center;
            margin-bottom: 25px;
            font-size: 12pt;
        }

        .tentang {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 25px 0 8px 0;
        }

        .tentang-judul {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 12pt;
        }

        .poin {
            margin: 20px 0;
            text-align: justify;
        }
        .poin ol {
            margin-left: 25px;
            padding-left: 0;
        }
        .poin li {
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .penutup {
            text-align: justify;
            margin: 20px 0;
        }

        .tempat-tanggal {
            text-align: center;
            margin: 35px 0 50px 0;
            line-height: 1.8;
        }

        .ttd {
            float: right;
            width: 40%;
            text-align: center;
        }
        .ttd .jabatan {
            font-weight: bold;
            margin-bottom: 55px;
        }
        .ttd .nama {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 200px;
            padding-top: 5px;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- LOGO & KOP DI ATAS SEKALI -->
    <div style="text-align: center; margin-bottom: 8px;">
        <img src="{{ public_path('assets/img/logo-pkk.png') }}" class="logo" alt="Logo PKK">
    </div>
    <div class="kop">TIM PENGGERAK PKK KABUPATEN/KOTA</div>
    <hr>

    <!-- JUDUL -->
    <div class="judul">SURAT EDARAN</div>

    <!-- NOMOR -->
    <div class="nomor">
        Nomor : {{ $suratEdaran->nomor }}
    </div>

    <!-- TENTANG -->
    <div class="tentang">TENTANG</div>
    <div class="tentang-judul">
        {{ strtoupper($suratEdaran->tentang) }}
    </div>

    <!-- ISI POIN -->
    <div class="poin">
        <ol>
            <li>{!! nl2br(e($suratEdaran->poin_1)) !!}</li>
            <li>{!! nl2br(e($suratEdaran->poin_2)) !!}</li>
            <li>{!! nl2br(e($suratEdaran->poin_3)) !!}</li>
            <li>{!! nl2br(e($suratEdaran->poin_4)) !!}</li>
        </ol>
    </div>

    <!-- PENUTUP -->
    <div class="penutup">
        Demikian surat edaran ini disampaikan untuk menjadi perhatian dan dilaksanakan dengan penuh tanggung jawab.
    </div>

    <!-- TEMPAT & TANGGAL -->
    <div class="tempat-tanggal">
        Dikeluarkan di : {{ $suratEdaran->dusun?->nama ?? '-' }}<br>
        Pada Tanggal : {{ $suratEdaran->tanggal?->format('d F Y') }}
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <div class="jabatan">
            {{ $suratEdaran->jabatan?->nama ?? 'KETUA UMUM/KETUA' }}<br>
            Sekretaris Umum/Sekretaris
        </div>
        <div class="nama">
            {{ $suratEdaran->nama_penanda_tangan }}
        </div>
    </div>

    <div class="clear"></div>

</body>
</html>