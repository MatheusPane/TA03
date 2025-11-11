{{-- resources/views/surat_keputusan/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SK PKK - {{ $suratKeputusan->nomor }}</title>
    <style>
        /* HEMAT RUANG: margin atas hanya 0.5cm */
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
            margin: 0 auto 3px;
        }

        /* KOP: RAPAT & RESMI */
        .kop {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }

        hr {
            border: none;
            border-top: 1.8px solid black;
            margin: 6px 0 12px 0;
        }

        /* JUDUL KEPUTUSAN */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 15px 0 8px 0;
            line-height: 1.4;
        }

        .nomor {
            text-align: center;
            font-size: 11.5pt;
            margin: 0 0 12px 0;
        }

        .tentang {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 18px 0 5px 0;
        }

        .tentang-isi {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 11.5pt;
        }

        /* TABEL MENIMBANG DLL */
        table {
            width: 100%;
            margin: 8px 0;
            line-height: 1.4;
        }
        td {
            vertical-align: top;
            padding: 1px 0;
        }
        .label {
            width: 120px;
            font-weight: normal;
            padding-right: 10px;
        }

        /* ISI MENETAPKAN */
        .menetapkan {
            margin: 12px 0;
        }
        .menetapkan strong {
            display: block;
            margin-bottom: 3px;
        }
        .indent {
            margin-left: 35px;
            text-align: justify;
        }

        /* TANDA TANGAN */
        .ttd {
            float: right;
            width: 45%;
            text-align: center;
            margin-top: 30px;
        }
        .ttd .jabatan {
            font-weight: bold;
            margin-bottom: 45px;
        }
        .ttd .nama {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 180px;
            padding-top: 3px;
            font-weight: bold;
        }

        /* TEMPAT & TANGGAL */
        .tempat-tanggal {
            text-align: right;
            margin: 20px 0 40px 0;
            line-height: 1.5;
            font-size: 11pt;
        }

        /* TEMBUSAN */
        .tembusan {
            margin-top: 10px;
            page-break-inside: avoid;
        }
        .tembusan ol {
            margin: 5px 0 0 20px;
            padding-left: 0;
        }
        .tembusan li {
            margin-bottom: 4px;
            font-size: 11pt;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- LOGO & KOP DI ATAS SEKALI -->
    <div style="text-align: center;">
        <img src="{{ public_path('assets/img/logo-pkk.png') }}" class="logo" alt="Logo PKK">
    </div>
    <div class="kop">
        PEMERINTAH KABUPATEN/KOTA<br>
        TIM PENGGERAK PKK {{ strtoupper($suratKeputusan->creator?->dusun ?? 'DESA/KELURAHAN') }}
    </div>
    <hr>

    <!-- JUDUL KEPUTUSAN -->
    <div class="judul">
        KEPUTUSAN KETUA UMUM/KETUA<br>
        TIM PENGGERAK PKK
    </div>

    <div class="nomor">
        Nomor: {{ $suratKeputusan->nomor }}/KEP/PKK/{{ $suratKeputusan->tanggal->format('Y') }}
    </div>

    <div class="tentang">TENTANG</div>
    <div class="tentang-isi">
        {{ strtoupper($suratKeputusan->tentang) }}
    </div>

    <!-- MENIMBANG, MENGINGAT, MEMPERHATIKAN -->
    <p style="margin: 12px 0 5px 0;"><strong>KETUA UMUM / KETUA TIM PENGGERAK PKK</strong></p>

    <table>
        <tr>
            <td class="label">Menimbang</td>
            <td>: {{ $suratKeputusan->menimbang ?: '....................................................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Mengingat</td>
            <td>:
                @foreach($suratKeputusan->mengingat ?? [] as $i => $item)
                    <div>{{ $i + 1 }}. {{ $item ?: '..............................................................................' }}</div>
                @endforeach
                @for($i = count($suratKeputusan->mengingat ?? []); $i < 3; $i++)
                    <div>{{ $i + 1 }}. ..............................................................................</div>
                @endfor
            </td>
        </tr>
        <tr>
            <td class="label">Memperhatikan</td>
            <td>: {{ $suratKeputusan->memperhatikan ?: '....................................................................................' }}</td>
        </tr>
    </table>

    <p class="text-center" style="margin: 18px 0 8px 0;"><strong>MEMUTUSKAN :</strong></p>
    <p style="margin: 0 0 10px 0;"><strong>MENTETAPKAN</strong></p>

    @foreach(['PERTAMA', 'KEDUA', 'KETIGA'] as $key)
        @if(isset($suratKeputusan->menetapkan[$key]) && $suratKeputusan->menetapkan[$key])
            <div class="menetapkan">
                <strong>{{ $key }} :</strong>
                <div class="indent">{!! nl2br(e($suratKeputusan->menetapkan[$key])) !!}</div>
            </div>
        @endif
    @endforeach

    <!-- TEMPAT & TANGGAL -->
    <div class="tempat-tanggal">
        Ditetapkan di : {{ $suratKeputusan->ditetapkan_di }}<br>
        Pada tanggal : {{ $suratKeputusan->tanggal->format('d F Y') }}
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <div class="jabatan">
            KETUA UMUM/KETUA<br>
            TIM PENGGERAK PKK
        </div>
        <div class="nama">
            {{ $suratKeputusan->nama_penanda_tangan }}
        </div>
        <div style="margin-top: 5px; font-size: 10.5pt;">
            {{ $suratKeputusan->jabatan?->nama ?? 'Jabatan Tidak Diketahui' }}
        </div>
    </div>

    <div class="clear"></div>

    <!-- TEMBUSAN -->
    @if(!empty($suratKeputusan->tembusan))
    <div class="tembusan">
        <p style="margin: 15px 0 5px 0;"><strong>Tembusan disampaikan kepada:</strong></p>
        <ol>
            @foreach($suratKeputusan->tembusan as $i => $item)
                <li>Yth. {{ $item }}</li>
            @endforeach
            @for($i = count($suratKeputusan->tembusan); $i < 3; $i++)
                <li>Yth. ....................................</li>
            @endfor
        </ol>
    </div>
    @endif

</body>
</html>