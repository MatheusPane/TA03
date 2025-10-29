<?php

namespace App\Http\Controllers;

use App\Models\Dasawisma;
use App\Models\Dusun;
use App\Models\DataWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasawismaController extends Controller
{
    public function index()
    {
        $dasawisma = Dasawisma::with(['dusun', 'ketua'])->latest()->get();
        return view('dasawisma.index', compact('dasawisma'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan Dasawisma.');
        }

        $dusun = Dusun::all();
        $warga = DataWarga::all();

        return view('dasawisma.create', compact('dusun', 'warga'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan Dasawisma.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'dusun_id' => 'nullable|exists:dusun,id',
            'ketua_warga_id' => 'nullable|exists:data_warga,id',
            'keterangan' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        Dasawisma::create($validated);

        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit Dasawisma.');
        }

        $dasawisma = Dasawisma::findOrFail($id);
        $dusun = Dusun::all();
        $warga = DataWarga::all();

        return view('dasawisma.edit', compact('dasawisma', 'dusun', 'warga'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui Dasawisma.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'dusun_id' => 'nullable|exists:dusun,id',
            'ketua_warga_id' => 'nullable|exists:data_warga,id',
            'keterangan' => 'nullable|string',
        ]);

        $validated['updated_by'] = Auth::id();

        $dasawisma = Dasawisma::findOrFail($id);
        $dasawisma->update($validated);

        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma berhasil diperbarui.');
    }

    public function destroy($id)
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403);
    }

    $dasawisma = Dasawisma::findOrFail($id);

    if ($dasawisma->anggota()->exists()) {
        return redirect()->route('dasawisma.index')
            ->with('error', 'Tidak dapat menghapus Dasawisma yang memiliki anggota.');
    }

    $dasawisma->delete();

    return redirect()->route('dasawisma.index')
        ->with('success', 'Dasawisma berhasil dihapus.');
}
}
