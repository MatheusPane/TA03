<?php

namespace App\Http\Controllers;

use App\Models\DesaKonfigurasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesaKonfigurasiController extends Controller
{
    public function index()
    {
        $configs = DesaKonfigurasi::orderBy('key')->get();
        return view('desa_konfigurasi.index', compact('configs'));
    }

    public function create()
    {
        return view('desa_konfigurasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:desa_konfigurasi,key',
            'value' => 'nullable|string',
        ]);

        DesaKonfigurasi::create([
            'key' => $request->key,
            'value' => $request->value,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('desa-konfigurasi.index')->with('success', 'Konfigurasi berhasil ditambahkan!');
    }

    public function edit(DesaKonfigurasi $desaKonfigurasi)
    {
        return view('desa_konfigurasi.edit', compact('desaKonfigurasi'));
    }

    public function update(Request $request, DesaKonfigurasi $desaKonfigurasi)
    {
        $request->validate([
            'key' => 'required|string|unique:desa_konfigurasi,key,' . $desaKonfigurasi->id,
            'value' => 'nullable|string',
        ]);

        $desaKonfigurasi->update([
            'key' => $request->key,
            'value' => $request->value,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('desa-konfigurasi.index')->with('success', 'Konfigurasi berhasil diperbarui!');
    }

    public function destroy(DesaKonfigurasi $desaKonfigurasi)
    {
        $desaKonfigurasi->delete();
        return redirect()->route('desa-konfigurasi.index')->with('success', 'Konfigurasi berhasil dihapus!');
    }
}
