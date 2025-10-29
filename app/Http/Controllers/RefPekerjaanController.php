<?php

namespace App\Http\Controllers;

use App\Models\RefPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefPekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaanList = RefPekerjaan::latest()->get();
        return view('ref_pekerjaan.index', compact('pekerjaanList'));
    }

    public function create()
    {
        return view('ref_pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_pekerjaan,nama',
        ]);

        RefPekerjaan::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan');
    }

    public function edit(RefPekerjaan $ref_pekerjaan)
    {
        return view('ref_pekerjaan.edit', compact('ref_pekerjaan'));
    }

    public function update(Request $request, RefPekerjaan $ref_pekerjaan)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_pekerjaan,nama,' . $ref_pekerjaan->id,
        ]);

        $ref_pekerjaan->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui');
    }

    public function destroy(RefPekerjaan $ref_pekerjaan)
    {
        $ref_pekerjaan->delete();
        return redirect()->route('ref_pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus');
    }
}
