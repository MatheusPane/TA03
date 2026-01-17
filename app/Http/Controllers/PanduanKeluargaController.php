<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\Dasawisma;
use App\Models\TahunPemerintahanKonfigurasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanduanKeluargaController extends Controller
{
   // app/Http/Controllers/PanduanKeluargaController.php
// app/Http/Controllers/PanduanKeluargaController.php

public function index(Request $request)
{
    if (!Auth::check() || !Auth::user()->hasRole(['Admin', 'Pengurus'])) {
        abort(403);
    }

    $query = DataKeluarga::with([
        'dusun', 'dasawisma', 'detail.sumberAir',
        'anggotaKeluarga' => function ($q) {
            $q->with([
                'warga' => function ($w) {
                    $w->with([
                        'statusPerkawinan', 'agama', 'pendidikan', 'pekerjaan','kebutuhanKhusus',
                        'kegiatanWarga' => fn($kq) => $kq->with('refKegiatan')->where('ikut', true)
                    ]);
                },
                'statusDalamKeluarga'  // INI YANG HILANG!
            ]);
        }
    ])
    ->whereHas('anggotaKeluarga', function ($q) {
        $q->whereHas('statusDalamKeluarga', function ($sq) {
            $sq->whereRaw('LOWER(nama) LIKE ?', ['%kepala%']);
        });
    })
    ->whereHas('detail');

    $keluargaList = $query->latest()->get();

    return view('panduan_keluarga.index', compact('keluargaList'));
}

public function show($id)
{
    if (!Auth::check() || !Auth::user()->hasRole(['Admin', 'Pengurus'])) {
        abort(403);
    }

    $keluarga = DataKeluarga::with([
        'dusun', 'dasawisma', 'detail.sumberAir',
        'anggotaKeluarga' => function ($q) {
            $q->with([
                'warga' => function ($w) {
                    $w->with([
                        'statusPerkawinan', 'agama', 'pendidikan', 'pekerjaan','kebutuhanKhusus',
                        'kegiatanWarga' => fn($kq) => $kq->with('refKegiatan')->where('ikut', true)
                    ]);
                },
                'statusDalamKeluarga'  // PASTIKAN INI ADA & DI-LOAD
            ]);
        }
    ])->findOrFail($id);

    // DEBUG: CEK APAKAH DATA ADA
    // dd($keluarga->anggotaKeluarga->pluck('statusDalamKeluarga.nama'));

    return view('panduan_keluarga.show', compact('keluarga'));
}
public function printShow(DataKeluarga $keluarga)
{
    $keluarga->load(['anggotaKeluarga.warga.statusPerkawinan', 'anggotaKeluarga.warga.agama', 
                     'anggotaKeluarga.warga.pendidikan', 'anggotaKeluarga.warga.pekerjaan','anggotaKeluarga.warga.kebutuhanKhusus',
                     'anggotaKeluarga.warga.kegiatanWarga.refKegiatan',
                     'anggotaKeluarga.statusDalamKeluarga', 'detail.sumberAir', 'dasawisma']);
    return view('panduan_keluarga.print-show', compact('keluarga'));
}
}