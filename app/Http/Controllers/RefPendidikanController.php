<?php

namespace App\Http\Controllers;

use App\Models\RefPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefPendidikanController extends Controller
{
    public function index()
    {
        $pendidikanList = RefPendidikan::latest()->get();
        return view('ref_pendidikan.index', compact('pendidikanList'));
    }

    public function create()
    {
        return view('ref_pendidikan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_pendidikan,nama',
        ]);

        RefPendidikan::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_pendidikan.index')->with('success', 'Pendidikan berhasil ditambahkan');
    }

    public function edit(RefPendidikan $ref_pendidikan)
    {
        return view('ref_pendidikan.edit', compact('ref_pendidikan'));
    }

    public function update(Request $request, RefPendidikan $ref_pendidikan)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_pendidikan,nama,' . $ref_pendidikan->id,
        ]);

        $ref_pendidikan->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_pendidikan.index')->with('success', 'Pendidikan berhasil diperbarui');
    }

    public function destroy(RefPendidikan $ref_pendidikan)
    {
        $ref_pendidikan->delete();
        return redirect()->route('ref_pendidikan.index')->with('success', 'Pendidikan berhasil dihapus');
    }
}
