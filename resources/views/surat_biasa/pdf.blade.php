{{-- resources/views/surat_biasa/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Biasa - {{ $suratBiasa->nomor }}</title>
    <style>
        /* HEMAT RUANG: margin atas 0.5cm */
        @page { margin: 0.5cm 2cm 2cm 2cm; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11.5pt;
            line-height: 1.4;
            margin: 0;
            color: #000;
        }

        /* LOGO: DI ATAS SEKALI */
        .logo {
            width: 75px;
            height: auto;
            display: block;
            margin: 0 auto 2px;
        }

        /* KOP: RAPAT & RESMI */
        .kop {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
            margin: 0 0 6px 0;
            line-height: 1.2;
        }

        hr {
            border: none;
            border-top: 1.8px solid black;
            margin: 5px 0 10px 0;
        }

        /* HEADER: NOMOR, TANGGAL, LAMPIRAN, PERIHAL */
        .header-table {
            width: 100%;
            margin: 8px 0 12px 0;
            font-size: 11.5pt;
            line-height: 1.3;
        }
        .header-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .header-table .label {
            width: 14%;
            font-weight: normal;
        }
        .header-table .colon {
            width: 2%;
            text-align: center;
        }
        .header-table .value {
            width: 49%;
        }
        .header-table .date {
            width: 35%;
            text-align: right;
            font-size: 11pt;
        }

        /* TUJUAN */
        .tujuan {
            text-align: center;
            margin: 18px 0 20px 0;
            line-height: 1.6;
        }
        .tujuan .underline {
            display: inline-block;
            border-bottom: 1px solid black;
            min-width: 240px;
            padding: 0 4px;
            font-weight: bold;
            font-size: 11.5pt;
        }

        /* ISI SURAT */
        .isi {
            text-align: justify;
            text-indent: 2.8cm;
            margin: 12px 0;
            line-height: 1.5;
        }

        /* TANDA TANGAN */
        .ttd {
            float: right;
            width: 42%;
            text-align: center;
            margin-top: 35px;
        }
        .ttd .jabatan {
            font-weight: bold;
            margin-bottom: 45px;
            font-size: 11.5pt;
        }
        .ttd .nama {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 180px;
            padding-top: 3px;
            font-weight: bold;
        }

        /* TEMBUSAN */
        .tembusan {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .tembusan p {
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        .tembusan ol {
            margin: 3px 0 0 18px;
            padding-left: 0;
        }
        .tembusan li {
            margin-bottom: 3px;
            font-size: 11pt;
        }
        .tembusan .underline {
            display: inline-block;
            border-bottom: 1px dotted black;
            min-width: 280px;
            margin-left: 4px;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- LOGO & KOP DI ATAS SEKALI -->
    <div style="text-align: center;">
        <img src="{{ public_path('assets/img/logo-pkk.png') }}" class="logo" alt="Logo PKK">
    </div>
    <div class="kop">TIM PENGGERAK PKK KABUPATEN/KOTA</div>
    <hr>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td class="label">Nomor Surat</td>
            <td class="colon">:</td>
            <td class="value">{{ $suratBiasa->nomor }}</td>
            <td class="date">
                {{ $suratBiasa->di }}, {{ $suratBiasa->tanggal?->format('d F Y') ?? now()->format('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td colspan="2">{{ $suratBiasa->lampiran ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td colspan="2">{{ $suratBiasa->perihal }}</td>
        </tr>
    </table>

    <!-- TUJUAN -->
    <div class="tujuan">
        Kepada Yth.<br>
        <span class="underline">{{ $suratBiasa->kepada }}</span><br>
        Di <span class="underline">{{ $suratBiasa->di }}</span>
    </div>

    <!-- ISI SURAT -->
    <div class="isi">
        {!! nl2br(e($suratBiasa->kata_pembuka)) !!}
    </div>
    <div class="isi">
        {!! nl2br(e($suratBiasa->isi_surat)) !!}
    </div>
    <div class="isi">
        {!! nl2br(e($suratBiasa->penutup)) !!}
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <div class="jabatan">
            {{ $suratBiasa->jabatan?->nama ?? 'KETUA UMUM/KETUA' }}
        </div>
        <div class="nama">
            {{ $suratBiasa->nama_penanda_tangan }}
        </div>
    </div>

    <div class="clear"></div>

    <!-- TEMBUSAN -->
    @if($suratBiasa->tembusan && count($suratBiasa->tembusan))
    <div class="tembusan">
        <p>Tembusan disampaikan kepada:</p>
        <ol>
            @foreach($suratBiasa->tembusan as $t)
                @if($t)
                <li>Yth. <span class="underline">{{ $t }}</span></li>
                @endif
            @endforeach
        </ol>
    </div>
    @endif

</body>
</html>