<?php

namespace App\Http\Controllers;

use App\Models\KegiatanWarga;
use App\Models\KegiatanWargaDetail;
use App\Models\RefJenisKader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanWargaDetailController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $data = KegiatanWarga::with([
            'warga',
            'refKegiatan',
            'detail.jenisKader'
        ])->orderByDesc('id')->get();        

        return view('kegiatan_warga_detail.index', compact('data'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        $kegiatanWarga = KegiatanWarga::with([
            'warga',
            'refKegiatan'
        ])->get();
        $jenisKader = RefJenisKader::with('kegiatan')->get();

        return view('kegiatan_warga_detail.create', compact(
            'kegiatanWarga',
            'jenisKader'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_warga_id'  => 'required|exists:kegiatan_warga,id',
            'ref_jenis_kader_id' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->ref_jenis_kader_id as $jenisId) {
                KegiatanWargaDetail::firstOrCreate([
                    'kegiatan_warga_id'  => $request->kegiatan_warga_id,
                    'ref_jenis_kader_id' => $jenisId,
                ]);
            }
        });

        return redirect()
            ->route('kegiatan-warga-detail.index')
            ->with('success', 'Sub kegiatan berhasil ditambahkan');
    }

    /**
     * EDIT
     */
    public function edit($kegiatanWargaId)
    {
        $kegiatanWarga = KegiatanWarga::with([
            'warga',
            'refKegiatan',
            'detail'
        ])->findOrFail($kegiatanWargaId);

        $jenisKader = RefJenisKader::with('kegiatan')->get();

        $selected = $kegiatanWarga->detail
            ->pluck('ref_jenis_kader_id')
            ->toArray();

        return view('kegiatan_warga_detail.edit', compact(
            'kegiatanWarga',
            'jenisKader',
            'selected'
        ));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $kegiatanWargaId)
    {
        $request->validate([
            'ref_jenis_kader_id' => 'array'
        ]);

        DB::transaction(function () use ($request, $kegiatanWargaId) {
            KegiatanWargaDetail::where(
                'kegiatan_warga_id',
                $kegiatanWargaId
            )->delete();

            foreach ($request->ref_jenis_kader_id ?? [] as $jenisId) {
                KegiatanWargaDetail::create([
                    'kegiatan_warga_id'  => $kegiatanWargaId,
                    'ref_jenis_kader_id' => $jenisId,
                ]);
            }
        });

        return redirect()
            ->route('kegiatan-warga-detail.index')
            ->with('success', 'Sub kegiatan berhasil diperbarui');
    }

    /**
     * DESTROY
     */
    public function destroy($id)
    {
        KegiatanWargaDetail::findOrFail($id)->delete();

        return back()->with('success', 'Sub kegiatan dihapus');
    }
}
