<?php

namespace App\Http\Controllers;

use App\Models\RefJenisKader;
use App\Models\RefKegiatanWarga;
use Illuminate\Http\Request;

class RefJenisKaderController extends Controller
{
    public function index()
    {
        $jenisKader = RefJenisKader::with('kegiatan')->get();
        return view('ref_jenis_kader.index', compact('jenisKader'));
    }

    public function create()
{
    $kegiatan = RefKegiatanWarga::where('active', true)->get();
    return view('ref_jenis_kader.create', compact('kegiatan'));
}

public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:100',
        'ref_kegiatan_warga_id' => 'required|exists:ref_kegiatan_warga,id'
    ]);

    RefJenisKader::create([
        'nama' => $request->nama,
        'ref_kegiatan_warga_id' => $request->ref_kegiatan_warga_id,
        'created_by' => auth()->id()
    ]);

    return redirect()
        ->route('ref-jenis-kader.index')
        ->with('success', 'Jenis kader berhasil ditambahkan');
}

    public function edit($id)
    {
        $jenisKader = RefJenisKader::findOrFail($id);
        $kegiatan = RefKegiatanWarga::all();

        return view('ref_jenis_kader.edit', compact('jenisKader', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $jenisKader = RefJenisKader::findOrFail($id);

        $request->validate([
            'ref_kegiatan_id' => 'required',
            'nama' => 'required'
        ]);

        $jenisKader->update($request->all());

        return redirect()->route('ref-jenis-kader.index')
            ->with('success', 'Jenis kader berhasil diupdate');
    }

    public function destroy($id)
    {
        RefJenisKader::findOrFail($id)->delete();

        return back()->with('success', 'Jenis kader dihapus');
    }
}
