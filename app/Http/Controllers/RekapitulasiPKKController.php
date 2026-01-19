<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use Illuminate\Http\Request;

class RekapitulasiPKKController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $dusun = Dusun::with([
            'keluarga.anggotaKeluarga.warga.kader.jenisKader',
            'keluarga.anggotaKeluarga.warga.kegiatanWarga.detail.jenisKader.kegiatan',
        ])->get();

        return view(
            'laporan.rekapitulasi_pkk',
            compact('dusun', 'tahun')
        );
    }
}
