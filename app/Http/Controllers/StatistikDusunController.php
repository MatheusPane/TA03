<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\DesaKonfigurasi;

class StatistikDusunController extends Controller
{
    public function index()
    {
        $statistik = DB::table('dusun')
            ->leftJoin('dasawisma', 'dasawisma.dusun_id', '=', 'dusun.id')
            ->leftJoin('data_keluarga', 'data_keluarga.dusun_id', '=', 'dusun.id')
            ->leftJoin('data_keluarga_anggota', 'data_keluarga_anggota.keluarga_id', '=', 'data_keluarga.id')
            ->leftJoin('data_warga', 'data_warga.id', '=', 'data_keluarga_anggota.warga_id')
            ->where('dusun.active', true)
            ->select(
                'dusun.id',
                'dusun.nama as nama_dusun',
                DB::raw('COUNT(DISTINCT dasawisma.id) as jumlah_dasawisma'),
                DB::raw('COUNT(DISTINCT data_keluarga.id) as jumlah_kk'),
                DB::raw("SUM(CASE WHEN data_warga.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlah_laki"),
                DB::raw("SUM(CASE WHEN data_warga.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlah_perempuan")
            )
            ->groupBy('dusun.id', 'dusun.nama')
            ->get();

        return view('statistik.dusun', compact('statistik'));
    }
    public function print()
    {
        // DATA STATISTIK DUSUN
        $statistik = DB::table('dusun')
            ->leftJoin('dasawisma', 'dasawisma.dusun_id', '=', 'dusun.id')
            ->leftJoin('data_keluarga', 'data_keluarga.dusun_id', '=', 'dusun.id')
            ->leftJoin('data_keluarga_anggota', 'data_keluarga_anggota.keluarga_id', '=', 'data_keluarga.id')
            ->leftJoin('data_warga', 'data_warga.id', '=', 'data_keluarga_anggota.warga_id')
            ->where('dusun.active', true)
            ->select(
                'dusun.nama as nama_dusun',
                DB::raw('COUNT(DISTINCT dasawisma.id) as jumlah_dasawisma'),
                DB::raw('COUNT(DISTINCT data_keluarga.id) as jumlah_kk'),
                DB::raw("SUM(CASE WHEN data_warga.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlah_laki"),
                DB::raw("SUM(CASE WHEN data_warga.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlah_perempuan")
            )
            ->groupBy('dusun.nama')
            ->orderBy('dusun.nama')
            ->get();

        // KONFIGURASI DESA
        $namaDesa   = DesaKonfigurasi::where('key', 'nama_desa')->value('value');
        $kecamatan  = DesaKonfigurasi::where('key', 'kecamatan')->value('value');
        $kabupaten  = DesaKonfigurasi::where('key', 'kabupaten')->value('value');
        $provinsi   = DesaKonfigurasi::where('key', 'provinsi')->value('value');
        $tahun      = DesaKonfigurasi::where('key', 'tahun')->value('value') ?? now()->year;

        return view('statistik.print_dusun', compact(
            'statistik',
            'namaDesa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'tahun'
        ));
    }
}
