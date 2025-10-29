<?php

namespace App\Http\Controllers;

use App\Models\RefAgama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefAgamaController extends Controller
{
    public function index()
    {
        $agamaList = RefAgama::latest()->get();
        return view('ref_agama.index', compact('agamaList'));
    }

    public function create()
    {
        return view('ref_agama.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_agama,nama',
        ]);

        RefAgama::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_agama.index')->with('success', 'Agama berhasil ditambahkan');
    }

    public function edit(RefAgama $ref_agama)
    {
        return view('ref_agama.edit', compact('ref_agama'));
    }

    public function update(Request $request, RefAgama $ref_agama)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_agama,nama,' . $ref_agama->id,
        ]);

        $ref_agama->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_agama.index')->with('success', 'Agama berhasil diperbarui');
    }

    public function destroy(RefAgama $ref_agama)
    {
        $ref_agama->delete();
        return redirect()->route('ref_agama.index')->with('success', 'Agama berhasil dihapus');
    }
}
