<?php

namespace App\Http\Controllers;

use App\Models\RefStatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefStatusPerkawinanController extends Controller
{
    public function index()
    {
        $statusList = RefStatusPerkawinan::latest()->get();
        return view('ref_status_perkawinan.index', compact('statusList'));
    }

    public function create()
    {
        return view('ref_status_perkawinan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_status_perkawinan,nama',
        ]);

        RefStatusPerkawinan::create([
            'nama' => $validated['nama'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_status_perkawinan.index')->with('success', 'Status perkawinan berhasil ditambahkan.');
    }

    public function edit(RefStatusPerkawinan $ref_status_perkawinan)
    {
        return view('ref_status_perkawinan.edit', compact('ref_status_perkawinan'));
    }

    public function update(Request $request, RefStatusPerkawinan $ref_status_perkawinan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_status_perkawinan,nama,' . $ref_status_perkawinan->id,
        ]);

        $ref_status_perkawinan->update([
            'nama' => $validated['nama'],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_status_perkawinan.index')->with('success', 'Status perkawinan berhasil diperbarui.');
    }

    public function destroy(RefStatusPerkawinan $ref_status_perkawinan)
    {
        $ref_status_perkawinan->delete();

        return redirect()->route('ref_status_perkawinan.index')->with('success', 'Status perkawinan berhasil dihapus.');
    }
}
