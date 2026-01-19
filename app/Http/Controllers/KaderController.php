<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\DataWarga;
use App\Models\RefJenisKader;
use App\Models\Dusun;
use Illuminate\Http\Request;

class KaderController extends Controller
{
    public function index()
    {
        $kader = Kader::with([
            'warga',
            'jenisKader',
            'dusun'
        ])->orderBy('tahun', 'desc')->get();

        return view('kader.index', compact('kader'));
    }

    public function create()
    {
        $warga = DataWarga::orderBy('nama')->get();
        $jenisKader = RefJenisKader::with('kegiatan')->get();
        $dusun = Dusun::orderBy('nama')->get();

        return view('kader.create', compact(
            'warga',
            'jenisKader',
            'dusun'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:data_warga,id',
            'ref_jenis_kader_id' => 'required|exists:ref_jenis_kader,id',
            'dusun_id' => 'required|exists:dusun,id',
            'tahun' => 'required|digits:4'
        ]);

        Kader::create([
            'warga_id' => $request->warga_id,
            'ref_jenis_kader_id' => $request->ref_jenis_kader_id,
            'dusun_id' => $request->dusun_id,
            'tahun' => $request->tahun,
            'created_by' => auth()->id()
        ]);

        return redirect()
            ->route('kader.index')
            ->with('success', 'Data kader berhasil disimpan');
    }

    public function edit($id)
    {
        $kader = Kader::findOrFail($id);
        $warga = DataWarga::orderBy('nama')->get();
        $jenisKader = RefJenisKader::with('kegiatan')->get();
        $dusun = Dusun::orderBy('nama')->get();

        return view('kader.edit', compact(
            'kader',
            'warga',
            'jenisKader',
            'dusun'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warga_id' => 'required|exists:data_warga,id',
            'ref_jenis_kader_id' => 'required|exists:ref_jenis_kader,id',
            'dusun_id' => 'required|exists:dusun,id',
            'tahun' => 'required|digits:4'
        ]);

        $kader = Kader::findOrFail($id);

        $kader->update([
            'warga_id' => $request->warga_id,
            'ref_jenis_kader_id' => $request->ref_jenis_kader_id,
            'dusun_id' => $request->dusun_id,
            'tahun' => $request->tahun,
            'updated_by' => auth()->id()
        ]);

        return redirect()
            ->route('kader.index')
            ->with('success', 'Data kader berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kader::findOrFail($id)->delete();

        return back()->with('success', 'Data kader berhasil dihapus');
    }
}
