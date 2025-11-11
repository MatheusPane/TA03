<?php

namespace App\Http\Controllers;

use App\Models\RefMakananPokok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefMakananPokokController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin']);
        $data = RefMakananPokok::latest()->get();
        return view('ref_makanan_pokok.index', compact('data'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin']);
        return view('ref_makanan_pokok.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_makanan_pokok,nama'
        ]);

        RefMakananPokok::create($validated);

        return redirect()->route('ref_makanan_pokok.index')
            ->with('success', 'Referensi makanan pokok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeRole(['Admin']);
        $item = RefMakananPokok::findOrFail($id);
        return view('ref_makanan_pokok.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_makanan_pokok,nama,' . $id
        ]);

        $item = RefMakananPokok::findOrFail($id);
        $item->update($validated);

        return redirect()->route('ref_makanan_pokok.index')
            ->with('success', 'Referensi makanan pokok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeRole(['Admin']);

        $item = RefMakananPokok::findOrFail($id);
        if ($item->keluargaDetails()->exists()) {
            return back()->with('error', 'Tidak dapat dihapus karena digunakan di detail keluarga.');
        }

        $item->delete();

        return redirect()->route('ref_makanan_pokok.index')
            ->with('success', 'Referensi makanan pokok berhasil dihapus.');
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}