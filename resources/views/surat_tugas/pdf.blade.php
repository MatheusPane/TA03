{{-- resources/views/surat_tugas/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas - {{ $suratTuga->nomor }}</title>
    <style>
        @page { margin: 2.2cm 2.8cm; size: A4; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }

        /* KOP SURAT */
        .kop-header {
            position: relative;
            text-align: center;
            margin-bottom: 8px;
        }
        .logo {
            position: absolute;
            left: 0;
            top: 5px;
            width: 68px;
            height: auto;
        }
        .kop-text {
            font-weight: bold;
            font-size: 13.5pt;
            margin: 0;
            padding-top: 12px;
        }
        .hr-kop {
            border-top: 3px double #000;
            margin: 10px 0 18px 0;
        }

        /* JUDUL */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 14.5pt;
            text-decoration: underline;
            margin: 12px 0 10px 0;
        }

        /* NOMOR */
        .nomor {
            text-align: center;
            margin-bottom: 22px;
            font-size: 11.8pt;
        }
        .nomor .value {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 280px;
            padding: 0 5px;
        }

        /* ISI SURAT */
        .content {
            margin-left: 60px;
            margin-right: 60px;
            text-align: justify;
        }

        /* GARIS PUTUS-PUTUS */
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 260px;
            margin: 0 4px;
        }

        /* DASAR */
        .dasar {
            margin-bottom: 18px;
        }
        .dasar ol {
            margin: 6px 0 0 42px;
            padding-left: 0;
        }
        .dasar li {
            margin-bottom: 3px;
        }

        /* MENUGASKAN */
        .menugaskan {
            text-align: center;
            font-weight: bold;
            margin: 20px 0 15px 0;
            font-size: 12.5pt;
        }

        .kepada {
            margin-bottom: 15px;
        }
        .kepada .indent {
            margin-left: 35px;
        }
        .kepada .label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }

        /* UNTUK */
        .untuk {
            margin-bottom: 15px;
        }
        .untuk .indent {
            margin-left: 35px;
        }

        /* WAKTU & TEMPAT */
        .waktu {
            margin-left: 135px;
            margin-bottom: 18px;
        }
        .waktu .label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }

        /* PARAGRAF */
        .paragraf {
            margin: 18px 0;
            text-align: justify;
        }

        /* DIKELUARKAN */
        .dikeluarkan {
            text-align: center;
            margin: 28px 0 20px 0;
            font-size: 11.8pt;
        }

        /* TTD */
        .ttd-container {
            display: flex;
            justify-content: flex-end;
            margin-right: 60px;
            margin-top: 15px;
        }
        .ttd {
            width: 300px;
            text-align: center;
        }
        .ttd .jabatan {
            font-weight: bold;
            margin-bottom: 58px;
            font-size: 12pt;
        }
        .ttd .garis {
            border-bottom: 1px solid #000;
            margin: 8px 0;
        }
        .ttd .nama {
            margin-top: 6px;
            font-weight: bold;
        }

        /* TEMBUSAN */
        .tembusan {
            margin-top: 32px;
        }
        .tembusan ol {
            margin-left: 45px;
            margin-top: 6px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-header">
        <img src="{{ public_path('assets/img/logo-pkk.png') }}" class="logo" alt="Logo PKK">
        <div class="kop-text">KOP SURAT</div>
    </div>
    <div class="hr-kop"></div>

    <!-- JUDUL -->
    <div class="judul">SURAT TUGAS</div>

    <!-- NOMOR -->
    <div class="nomor">
        Nomor : <span class="value">{{ $suratTuga->nomor }}</span>
    </div>

    <div class="content">

        @php
            // DECODE AMAN
            $dasar = is_string($suratTuga->dasar ?? '') 
                ? json_decode($suratTuga->dasar, true) 
                : ($suratTuga->dasar ?? []);

            $tembusan = is_string($suratTuga->tembusan ?? '') 
                ? json_decode($suratTuga->tembusan, true) 
                : ($suratTuga->tembusan ?? []);
        @endphp

        <!-- DASAR -->
        <div class="dasar">
            <strong>Dasar :</strong>
            <ol>
                @forelse($dasar as $d)
                    @if(trim($d)) <li>{{ $d }}</li> @endif
                @empty
                    <li><span class="dotted-line"></span></li>
                    <li><span class="dotted-line"></span></li>
                @endforelse
            </ol>
        </div>

        <!-- MENUGASKAN -->
        <div class="menugaskan">
            KETUA UMUM/KETUA TIM PENGGERAK PKK MENUGASKAN:
        </div>

        <!-- KEPADA -->
        <div class="kepada">
            <div class="indent">
                <strong>Kepada :</strong><br>
                Nama <span class="label"></span> : <span class="value">{{ $suratTuga->penerimaTugas?->nama ?? '' }}</span><br>
                Jabatan <span class="label"></span> : <span class="value">{{ $suratTuga->penerimaTugas?->jabatan?->nama ?? '' }}</span>
            </div>
        </div>

        <!-- UNTUK -->
        <div class="untuk">
            <p>
                Untuk melaksanakan tugas <span class="dotted-line"></span><br>
                <span class="indent">{!! nl2br(e($suratTuga->untuk)) !!}</span><br>
                <span>pada: Hari/Tanggal <span class="dotted-line">{{ $suratTuga->hari_tanggal }}</span></span>
            </p>
        </div>

        <!-- WAKTU & TEMPAT -->
        <div class="waktu">
            Waktu <span class="label"></span> : <span class="value">{{ $suratTuga->waktu }}</span><br>
            Tempat <span class="label"></span> : <span class="value">{{ $suratTuga->tempat }}</span>
        </div>

        <!-- PARAGRAF -->
        <div class="paragraf">
            Surat Tugas ini mulai berlaku pada tanggal dikeluarkan dan setelah tugas selesai agar memberikan laporan tertulis kepada Ketua Umum/Ketua.
        </div>

        <!-- DIKELUARKAN -->
        <div class="dikeluarkan">
            Dikeluarkan di <span class="dotted-line">{{ $suratTuga->dusun?->nama ?? '' }}</span><br>
            Pada Tanggal <span class="dotted-line">{{ $suratTuga->tanggal?->format('d F Y') }}</span>
        </div>

        <!-- TTD -->
        <div class="ttd-container">
            <div class="ttd">
                <div class="jabatan">KETUA UMUM/KETUA</div>
                <div class="garis"></div>
                <div class="nama">{{ $suratTuga->nama_penanda_tangan }}</div>
            </div>
        </div>

        <!-- TEMBUSAN -->
        @if($tembusan && count(array_filter($tembusan)))
        <div class="tembusan">
            <p><strong>Tembusan disampaikan kepada:</strong></p>
            <ol>
                @foreach($tembusan as $t)
                    @if(trim($t)) <li>Yth. {{ $t }}</li> @endif
                @endforeach
            </ol>
        </div>
        @endif

    </div>
</body>
</html>