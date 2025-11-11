{{-- resources/views/surat_kuasa/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Kuasa - {{ $suratKuasa->nomor }}</title>
    <style>
        @page { margin: 0.5cm 2cm 2cm 2cm; }
        body { font-family: 'Times New Roman', serif; font-size: 11.5pt; line-height: 1.4; margin: 0; }
        .logo { width: 75px; margin: 0 auto 3px; display: block; }
        .kop { text-align: center; font-weight: bold; font-size: 13pt; text-transform: uppercase; margin: 0 0 6px; }
        hr { border: none; border-top: 1.8px solid black; margin: 5px 0 10px; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin: 15px 0 8px; }
        .nomor { text-align: center; margin-bottom: 15px; }
        .label { width: 120px; display: inline-block; font-weight: normal; }
        .value { display: inline-block; border-bottom: 1px dotted black; min-width: 300px; margin-left: 5px; }
        .isi { margin: 15px 0; text-align: justify; }
        .ttd { float: right; width: 40%; text-align: center; margin-top: 40px; }
        .ttd .jabatan { font-weight: bold; margin-bottom: 50px; }
        .ttd .nama { border-bottom: 1px solid black; display: inline-block; min-width: 180px; padding-top: 3px; }
        .tembusan { margin-top: 30px; }
        .tembusan ol { margin: 5px 0 0 20px; }
        .tembusan li { margin-bottom: 4px; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <img src="{{ public_path('assets/img/logo-pkk.png') }}" class="logo" alt="Logo PKK">
    <div class="kop">TIM PENGGERAK PKK KABUPATEN/KOTA</div>
    <hr>

    <div class="judul">SURAT KUASA</div>

    <div class="nomor">Nomor : {{ $suratKuasa->nomor }}</div>

    <p>Yang bertanda tangan di bawah ini:</p>
    <p><span class="label">Nama</span> : <span class="value">{{ $suratKuasa->pemberiKuasa->nama }}</span></p>
    <p><span class="label">Jabatan</span> : <span class="value">{{ $suratKuasa->pemberiKuasa->jabatan?->nama ?? '-' }}</span></p>
    <p><span class="label">Alamat</span> : <span class="value">{{ $suratKuasa->dusun?->nama ?? '-' }}</span></p>

    <p style="margin-top: 15px;">Memberikan kuasa kepada :</p>
    <p><span class="label">Nama</span> : <span class="value">{{ $suratKuasa->penerimaKuasa->nama }}</span></p>
    <p><span class="label">Jabatan</span> : <span class="value">{{ $suratKuasa->penerimaKuasa->jabatan?->nama ?? '-' }}</span></p>
    <p><span class="label">Alamat</span> : <span class="value">{{ $suratKuasa->dusun?->nama ?? '-' }}</span></p>

    <p style="margin-top: 15px;"><strong>Untuk</strong></p>
    <div class="isi">{!! nl2br(e($suratKuasa->untuk)) !!}</div>

    <p style="text-align: center; margin: 30px 0;">
        Dikeluarkan di : {{ $suratKuasa->dusun?->nama ?? '-' }}<br>
        Pada Tanggal : {{ $suratKuasa->tanggal?->format('d F Y') }}
    </p>

    <div class="ttd">
        <div class="jabatan">KETUA UMUM/KETUA</div>
        <div class="nama">{{ $suratKuasa->nama_penanda_tangan }}</div>
    </div>
    <div class="clear"></div>

    @if($suratKuasa->tembusan && count($suratKuasa->tembusan))
    <div class="tembusan">
        <p><strong>Tembusan disampaikan kepada:</strong></p>
        <ol>
            @foreach($suratKuasa->tembusan as $i => $t)
                @if($t)<li>Yth. {{ $t }}</li>@endif
            @endforeach
        </ol>
    </div>
    @endif

</body>
</html>