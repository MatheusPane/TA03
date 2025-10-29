<?php

namespace App\Http\Controllers;

use App\Models\RefJenisKelompokBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefJenisKelompokBelajarController extends Controller
{
    public function index()
    {
        $kelompokList = RefJenisKelompokBelajar::latest()->get();
        return view('ref_jenis_kelompok_belajar.index', compact('kelompokList'));
    }

    public function create()
    {
        return view('ref_jenis_kelompok_belajar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_kelompok_belajar,nama',
        ]);

        RefJenisKelompokBelajar::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_kelompok_belajar.index')->with('success', 'Jenis Kelompok Belajar berhasil ditambahkan');
    }

    public function edit(RefJenisKelompokBelajar $ref_jenis_kelompok_belajar)
    {
        return view('ref_jenis_kelompok_belajar.edit', compact('ref_jenis_kelompok_belajar'));
    }

    public function update(Request $request, RefJenisKelompokBelajar $ref_jenis_kelompok_belajar)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_kelompok_belajar,nama,' . $ref_jenis_kelompok_belajar->id,
        ]);

        $ref_jenis_kelompok_belajar->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_kelompok_belajar.index')->with('success', 'Jenis Kelompok Belajar berhasil diperbarui');
    }

    public function destroy(RefJenisKelompokBelajar $ref_jenis_kelompok_belajar)
    {
        $ref_jenis_kelompok_belajar->delete();
        return redirect()->route('ref_jenis_kelompok_belajar.index')->with('success', 'Jenis Kelompok Belajar berhasil dihapus');
    }
}
