<?php

namespace App\Http\Controllers;

use App\Models\RefKebutuhanKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefKebutuhanKhususController extends Controller
{
    public function index()
    {
        $data = RefKebutuhanKhusus::with(['createdBy', 'updatedBy'])->get();
        return view('ref_kebutuhan_khusus.index', compact('data'));
    }
    public function create()
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403, 'Anda tidak memiliki izin untuk menambahkan data.');
    }

    return view('ref_kebutuhan_khusus.create');
}

public function edit(RefKebutuhanKhusus $refKebutuhanKhusus)
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403, 'Anda tidak memiliki izin untuk mengedit data.');
    }

    return view('ref_kebutuhan_khusus.edit', compact('refKebutuhanKhusus'));
}

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kebutuhan_khusus,nama',
        ]);

        RefKebutuhanKhusus::create([
            'nama' => $validated['nama'],
            'created_by' => Auth::id(),
            'active' => true,
        ]);

        return redirect()
            ->route('ref_kebutuhan_khusus.index')
            ->with('success', 'Status dalam keluarga berhasil ditambahkan!');
    }

    public function update(Request $request, RefKebutuhanKhusus $refKebutuhanKhusus)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:ref_kebutuhan_khusus,nama,' . $refKebutuhanKhusus->id,
        ]);

        $refKebutuhanKhusus->update([
            'nama' => $validated['nama'],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(RefKebutuhanKhusus $refKebutuhanKhusus)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data.');
        }

        $refKebutuhanKhusus->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
