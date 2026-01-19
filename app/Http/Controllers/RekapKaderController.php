<?php

namespace App\Http\Controllers;

use App\Models\RefKegiatanWarga;
use Illuminate\Http\Request;

class RekapKaderController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = RefKegiatanWarga::with([
            'jenisKader.kader.dusun'
        ])->get();
        

        return view('laporan.rekap_kader', compact('data', 'tahun'));
    }
}
