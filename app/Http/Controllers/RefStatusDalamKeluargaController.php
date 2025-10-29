<?php

namespace App\Http\Controllers;

use App\Models\RefStatusDalamKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefStatusDalamKeluargaController extends Controller
{
    public function index()
    {
        $data = RefStatusDalamKeluarga::with(['createdBy', 'updatedBy'])->get();
        return view('ref_status_dalam_keluarga.index', compact('data'));
    }
    public function create()
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403, 'Anda tidak memiliki izin untuk menambahkan data.');
    }

    return view('ref_status_dalam_keluarga.create');
}

public function edit(RefStatusDalamKeluarga $refStatusDalamKeluarga)
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403, 'Anda tidak memiliki izin untuk mengedit data.');
    }

    return view('ref_status_dalam_keluarga.edit', compact('refStatusDalamKeluarga'));
}

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:ref_status_dalam_keluarga,nama',
        ]);

        RefStatusDalamKeluarga::create([
            'nama' => $validated['nama'],
            'created_by' => Auth::id(),
            'active' => true,
        ]);

        return redirect()
            ->route('ref_status_dalam_keluarga.index')
            ->with('success', 'Status dalam keluarga berhasil ditambahkan!');
    }

    public function update(Request $request, RefStatusDalamKeluarga $refStatusDalamKeluarga)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:ref_status_dalam_keluarga,nama,' . $refStatusDalamKeluarga->id,
        ]);

        $refStatusDalamKeluarga->update([
            'nama' => $validated['nama'],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(RefStatusDalamKeluarga $refStatusDalamKeluarga)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data.');
        }

        $refStatusDalamKeluarga->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
