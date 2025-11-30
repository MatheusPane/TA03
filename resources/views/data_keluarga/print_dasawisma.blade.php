<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Dasa Wisma - {{ $keluarga->no_kk }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9pt; margin: 15mm 10mm; line-height: 1.4; }
        h2 { text-align: center; font-size: 13pt; margin: 0 0 10px 0; font-weight: bold; }
        .info { font-size: 10pt; margin-bottom: 12px; }
        .info table { width: 100%; border: none; }
        .info td { padding: 2px 5px; border: none; }
        .info .label { width: 120px; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; font-size: 8.5pt; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 4px 3px; text-align: center; vertical-align: middle; }
        .table th { background-color: #f0f0f0; font-weight: bold; font-size: 8pt; }
        .text-left { text-align: left !important; }
        .checkmark { font-family: 'DejaVu Sans', sans-serif; font-size: 16pt; font-weight: bold; }
        .signature { margin-top: 40px; text-align: right; font-size: 10pt; }
        .no-print { display: none; }
        @media print {
            body { margin: 8mm; }
            .no-print { display: block !important; text-align: center; margin-top: 30px; }
            .no-print button { padding: 12px 30px; font-size: 16px; }
        }
    </style>
</head>
<body>

    <h2>REKAPITULASI<br>CATATAN DATA DAN KEGIATAN WARGA<br>KELOMPOK DASA WISMA</h2>

    <div class="info">
        <table>
            <tr>
                <td class="label">Dasa Wisma</td>
                <td>: <strong>{{ $keluarga->dasawisma?->nama ?? '_________________' }}</strong></td>
                <td></td>
                <td class="label">DESA/KELURAHAN</td>
                <td>: <strong>{{ $namaDesa?->value ?? '__________' }}, Kec. {{ $kecamatan?->value ?? '__________' }}, Kab. {{ $kabupaten?->value ?? '__________' }}</strong></td>
            </tr>
            <tr>
                <td class="label">RT / RW</td>
                <td>: <strong>{{ $keluarga->rt ?? '-' }} / {{ $keluarga->rw ?? '-' }}</strong></td>
                <td></td>
                <td class="label">TAHUN</td>
                <td>: <strong>{{ $config?->year ?? now()->year }}</strong></td>
            </tr>
        </table>
    </div>

    {{-- HITUNG KEPALA KELUARGA YANG BENAR (sama persis seperti di Catatan Keluarga) --}}
    @php
        $kepala = $keluarga->anggotaKeluarga
            ->firstWhere(fn($a) => $a->statusDalamKeluarga && 
                str_contains(strtolower($a->statusDalamKeluarga->nama), 'kepala'))
            ?->warga;
    @endphp

    <table class="table">
        <thead>
            <tr>
                <th rowspan="3">NO</th>
                <th rowspan="3">NAMA KEPALA RUMAH TANGGA</th>
                <th rowspan="3">JML KK</th>
                <th colspan="2">TOTAL</th>
                <th rowspan="2">BALITA</th>
                <th rowspan="2">PUS</th>
                <th rowspan="2">WUS</th>
                <th rowspan="2">IBU HAMIL</th>
                <th rowspan="2">IBU MENYUSUI</th>
                <th rowspan="2">LANSIA</th>
                <th rowspan="2">BUTA</th>
                <th rowspan="2">BERKEBUTUHAN<br>KHUSUS</th>
                <th colspan="6">KRITERIA RUMAH</th>
                <th colspan="3">SUMBER AIR KELUARGA</th>
                <th colspan="2">MAKANAN POKOK</th>
                <th rowspan="3">KET</th>
            </tr>
            <tr>
                <th>L</th><th>P</th>
                <th>SEHAT LAYAK HUNI</th>
                <th>TIDAK SEHAT</th>
                <th>TEMPAT SAMPAH</th>
                <th>SPAL</th>
                <th>JAMBAN</th>
                <th>STIKER P4K</th>
                <th>PDAM</th><th>SUMUR</th><th>DLL</th>
                <th>BERAS</th><th>NON BERAS</th>
            </tr>
            <tr>
                <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th>
                <th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="text-left">
                    <strong>{{ $kepala?->nama ?? $keluarga->no_kk }}</strong>
                </td>
                <td>1</td>
                <td>{{ $keluarga->detail->laki_laki ?? 0 }}</td>
                <td>{{ $keluarga->detail->perempuan ?? 0 }}</td>
                <td><strong>{{ $keluarga->detail->balita ?? 0 }}</strong></td>
                <td>{{ $keluarga->detail->pus ?? 0 }}</td>
                <td>{{ $keluarga->detail->wus ?? 0 }}</td>
                <td>{{ $keluarga->detail->ibu_hamil ?? 0 }}</td>
                <td>{{ $keluarga->detail->ibu_menyusui ?? 0 }}</td>
                <td>{{ $keluarga->detail->lansia ?? 0 }}</td>
                <td>{{ $keluarga->detail->buta ?? 0 }}</td>
                <td><strong>{{ $keluarga->detail->kebutuhan_khusus ?? 0 }}</strong></td>

                <!-- KRITERIA RUMAH -->
                <td class="checkmark">{{ $keluarga->detail->kriteria_rumah === 'Sehat' ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->kriteria_rumah === 'Kurang Sehat' ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->punya_tempat_sampah ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->punya_saluran_limbah ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->punya_jamban ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->stiker_p4k ? '✓' : '' }}</td>

                <!-- SUMBER AIR -->
                <td class="checkmark">{{ optional($keluarga->detail->sumberAir)->id == 1 ? '✓' : '' }}</td>
                <td class="checkmark">{{ optional($keluarga->detail->sumberAir)->id == 2 ? '✓' : '' }}</td>
                <td class="checkmark">{{ optional($keluarga->detail->sumberAir)->id > 2 || !$keluarga->detail->sumber_air_id ? '✓' : '' }}</td>

                <!-- MAKANAN POKOK -->
                <td class="checkmark">{{ $keluarga->detail->makanan_pokok === 'Beras' ? '✓' : '' }}</td>
                <td class="checkmark">{{ $keluarga->detail->makanan_pokok === 'Non Beras' ? '✓' : '' }}</td>

                <td>-</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background: #f0f0f0;">
                <td colspan="2">JUMLAH</td>
                <td>1</td>
                <td>{{ $keluarga->detail->laki_laki ?? 0 }}</td>
                <td>{{ $keluarga->detail->perempuan ?? 0 }}</td>
                <td>{{ $keluarga->detail->balita ?? 0 }}</td>
                <td>{{ $keluarga->detail->pus ?? 0 }}</td>
                <td>{{ $keluarga->detail->wus ?? 0 }}</td>
                <td>{{ $keluarga->detail->ibu_hamil ?? 0 }}</td>
                <td>{{ $keluarga->detail->ibu_menyusui ?? 0 }}</td>
                <td>{{ $keluarga->detail->lansia ?? 0 }}</td>
                <td>{{ $keluarga->detail->buta ?? 0 }}</td>
                <td>{{ $keluarga->detail->kebutuhan_khusus ?? 0 }}</td>
                <td colspan="13"></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>