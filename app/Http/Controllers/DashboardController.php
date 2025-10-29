<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\DataKeluarga;
use App\Models\Dasawisma;
use App\Models\Dusun;
use App\Models\DataKeluargaAnggota; 
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // === TOTAL ===
    $totalWarga = DataWarga::count();
    $totalKeluarga = DataKeluarga::count();
    $totalDasawisma = Dasawisma::count();
    $totalDusun = Dusun::count();

    // === REKAP WARGA ===
    $rekapWarga = [
        // 1. Warga per Dusun
        'dusun' => DataKeluargaAnggota::join('data_keluarga', 'data_keluarga_anggota.keluarga_id', '=', 'data_keluarga.id')
            ->join('dusun', 'data_keluarga.dusun_id', '=', 'dusun.id')
            ->join('data_warga', 'data_keluarga_anggota.warga_id', '=', 'data_warga.id')
            ->select('dusun.nama', DB::raw('count(*) as total'))
            ->groupBy('dusun.id', 'dusun.nama')
            ->pluck('total', 'nama')
            ->toArray(),
    
        // 2. Warga per Agama
        'agama' => DataWarga::join('ref_agama', 'data_warga.agama_id', '=', 'ref_agama.id')
            ->select('ref_agama.nama as nama', DB::raw('count(*) as total'))
            ->groupBy('ref_agama.id', 'ref_agama.nama')
            ->pluck('total', 'nama')
            ->toArray(),
    
        // 3. Jenis Kelamin
        'jk' => [
            'Laki-laki' => DataWarga::where('jenis_kelamin', 'L')->count(),
            'Perempuan' => DataWarga::where('jenis_kelamin', 'P')->count(),
        ],
    
        // 4. Status Perkawinan
        'perkawinan' => DataWarga::join('ref_status_perkawinan', 'data_warga.status_perkawinan_id', '=', 'ref_status_perkawinan.id')
            ->select('ref_status_perkawinan.nama as nama', DB::raw('count(*) as total'))
            ->groupBy('ref_status_perkawinan.id', 'ref_status_perkawinan.nama')
            ->pluck('total', 'nama')
            ->toArray(),
    
        // 5. Pendidikan → DIPERBAIKI!
        'pendidikan' => DataWarga::join('ref_pendidikan', 'data_warga.pendidikan_id', '=', 'ref_pendidikan.id')
            ->select('ref_pendidikan.nama as nama', DB::raw('count(*) as total'))
            ->groupBy('ref_pendidikan.id', 'ref_pendidikan.nama')
            ->pluck('total', 'nama')
            ->toArray(),
    
        // 6. BONUS: Pekerjaan (jika ada)
        'pekerjaan' => DataWarga::join('ref_pekerjaan', 'data_warga.pekerjaan_id', '=', 'ref_pekerjaan.id')
            ->select('ref_pekerjaan.nama as nama', DB::raw('count(*) as total')) // ← GANTI nama_pekerjaan → nama
            ->groupBy('ref_pekerjaan.id', 'ref_pekerjaan.nama')                  // ← SAMA
            ->pluck('total', 'nama')
            ->toArray(),
    ];

    return view('dashboard', compact(
        'totalWarga', 'totalKeluarga', 'totalDasawisma', 'totalDusun', 'rekapWarga'
    ));
}
}