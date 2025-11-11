<?php

namespace App\Http\Controllers;

use App\Models\RefJenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefJenisUsahaController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin']);
        $data = RefJenisUsaha::latest()->get();
        return view('ref_jenis_usaha.index', compact('data'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin']);
        return view('ref_jenis_usaha.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_jenis_usaha,nama'
        ]);

        RefJenisUsaha::create($validated);

        return redirect()->route('ref_jenis_usaha.index')
            ->with('success', 'Referensi jenis usaha berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeRole(['Admin']);
        $item = RefJenisUsaha::findOrFail($id);
        return view('ref_jenis_usaha.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin']);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ref_jenis_usaha,nama,' . $id
        ]);

        $item = RefJenisUsaha::findOrFail($id);
        $item->update($validated);

        return redirect()->route('ref_jenis_usaha.index')
            ->with('success', 'Referensi jenis usaha berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeRole(['Admin']);

        $item = RefJenisUsaha::findOrFail($id);
        if ($item->keluargaDetails()->exists()) {
            return back()->with('error', 'Tidak dapat dihapus karena digunakan di detail keluarga.');
        }

        $item->delete();

        return redirect()->route('ref_jenis_usaha.index')
            ->with('success', 'Referensi jenis usaha berhasil dihapus.');
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}