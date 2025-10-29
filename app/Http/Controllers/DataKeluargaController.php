<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\Dusun;
use App\Models\Dasawisma; // Tambahan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluargaController extends Controller
{
    public function index()
    {
        $dataKeluarga = DataKeluarga::with(['dusun', 'dasawisma'])->latest()->get(); // Tambahkan 'dasawisma' ke eager loading
        return view('data_keluarga.index', compact('dataKeluarga'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan data keluarga.');
        }

        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all(); // Tambahan
        return view('data_keluarga.create', compact('dusun', 'dasawisma'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan data keluarga.');
        }

        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:data_keluarga,no_kk',
            'dusun_id' => 'required|exists:dusun,id',
            'dasawisma_id' => 'nullable|exists:dasawisma,id', // Validasi dasawisma_id
        ]);

        $validated['created_by'] = Auth::id();
        DataKeluarga::create($validated);

        return redirect()->route('data_keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data keluarga.');
        }

        $keluarga = DataKeluarga::findOrFail($id);
        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all(); // Tambahan

        return view('data_keluarga.edit', compact('keluarga', 'dusun', 'dasawisma'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Kader')) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui data keluarga.');
        }

        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:data_keluarga,no_kk,' . $id,
            'dusun_id' => 'required|exists:dusun,id',
            'dasawisma_id' => 'nullable|exists:dasawisma,id', // Validasi dasawisma_id
        ]);

        $validated['updated_by'] = Auth::id();

        $keluarga = DataKeluarga::findOrFail($id);
        $keluarga->update($validated);

        return redirect()->route('data_keluarga.index')->with('success', 'Data keluarga berhasil diperbarui.');
    }

    public function destroy($id)
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403, 'Hanya Admin yang dapat menghapus data keluarga.');
    }

    $keluarga = DataKeluarga::findOrFail($id);

    // Gunakan relasi yang sudah didefinisikan
    if ($keluarga->anggotaKeluarga()->exists()) {
        return redirect()->route('data_keluarga.index')
            ->with('error', 'Tidak dapat menghapus keluarga yang memiliki anggota.');
    }

    $keluarga->delete();

    return redirect()->route('data_keluarga.index')
        ->with('success', 'Data keluarga berhasil dihapus.');
}
}