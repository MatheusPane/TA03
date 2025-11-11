<?php

namespace App\Http\Controllers;

use App\Models\RefSumberAir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefSumberAirController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin']);
        $data = RefSumberAir::latest()->get();
        return view('ref_sumber_air.index', compact('data'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin']);
        return view('ref_sumber_air.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_sumber_air,nama'
        ]);

        RefSumberAir::create($validated);

        return redirect()->route('ref_sumber_air.index')
            ->with('success', 'Referensi sumber air berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeRole(['Admin']);
        $item = RefSumberAir::findOrFail($id);
        return view('ref_sumber_air.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_sumber_air,nama,' . $id
        ]);

        $item = RefSumberAir::findOrFail($id);
        $item->update($validated);

        return redirect()->route('ref_sumber_air.index')
            ->with('success', 'Referensi sumber air berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeRole(['Admin']);

        $item = RefSumberAir::findOrFail($id);
        if ($item->keluargaDetails()->exists()) {
            return back()->with('error', 'Tidak dapat dihapus karena digunakan di detail keluarga.');
        }

        $item->delete();

        return redirect()->route('ref_sumber_air.index')
            ->with('success', 'Referensi sumber air berhasil dihapus.');
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}