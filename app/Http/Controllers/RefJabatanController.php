<?php

namespace App\Http\Controllers;

use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefJabatanController extends Controller
{
    public function index()
    {
        $jabatanList = RefJabatan::latest()->get();
        return view('ref_jabatan.index', compact('jabatanList'));
    }

    public function create()
    {
        return view('ref_jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jabatan,nama',
        ]);

        RefJabatan::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(RefJabatan $ref_jabatan)
    {
        return view('ref_jabatan.edit', compact('ref_jabatan'));
    }

    public function update(Request $request, RefJabatan $ref_jabatan)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jabatan,nama,' . $ref_jabatan->id,
        ]);

        $ref_jabatan->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(RefJabatan $ref_jabatan)
    {
        $ref_jabatan->delete();
        return redirect()->route('ref_jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
