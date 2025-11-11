<?php

namespace App\Http\Controllers;

use App\Models\RefKegiatanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefKegiatanWargaController extends Controller
{
    public function index()
    {
        $kegiatanList = RefKegiatanWarga::latest()->get();
        return view('ref_kegiatan_warga.index', compact('kegiatanList'));
    }

    public function create()
    {
        return view('ref_kegiatan_warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kegiatan_warga,nama',
        ]);

        RefKegiatanWarga::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_kegiatan_warga.index')->with('success', 'Jenis Kegiatan Warga berhasil ditambahkan');
    }

    public function edit(RefKegiatanWarga $ref_kegiatan_warga)
    {
        return view('ref_kegiatan_warga.edit', compact('ref_kegiatan_warga'));
    }

    public function update(Request $request, RefKegiatanWarga $ref_kegiatan_warga)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kegiatan_warga,nama,' . $ref_kegiatan_warga->id,
        ]);

        $ref_kegiatan_warga->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_kegiatan_warga.index')->with('success', 'Jenis Kegiatan Warga berhasil diperbarui');
    }

    public function destroy(RefKegiatanWarga $ref_kegiatan_warga)
    {
        $ref_kegiatan_warga->delete();
        return redirect()->route('ref_kegiatan_warga.index')->with('success', 'Jenis Kegiatan Warga berhasil dihapus');
    }
}
