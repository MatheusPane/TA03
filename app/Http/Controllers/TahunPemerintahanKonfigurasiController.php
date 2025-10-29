<?php

namespace App\Http\Controllers;

use App\Models\TahunPemerintahanKonfigurasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahunPemerintahanKonfigurasiController extends Controller
{
    /**
     * Tampilkan semua data tahun pemerintahan
     */
    public function index()
    {
        // Ambil semua data dari tabel tahun_pemerintahan_konfigurasi
        $tahunList = TahunPemerintahanKonfigurasi::latest()->get();

        // Kirim ke view
        return view('tahun.index', compact('tahunList'));
    }

    /**
     * Tampilkan form tambah data baru
     */
    public function create()
    {
        return view('tahun.create');
    }

    /**
     * Simpan data baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun_pemerintahan_konfigurasi,tahun',
            'nama'  => 'nullable|string|max:255',
        ]);

        TahunPemerintahanKonfigurasi::create([
            ...$validated,
            'created_by' => Auth::id(),
            'active' => true,
        ]);

        return redirect()->route('tahun.index')->with('success', 'Tahun pemerintahan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit(TahunPemerintahanKonfigurasi $tahun)
    {
        return view('tahun.edit', compact('tahun'));
    }

    /**
     * Update data
     */
    public function update(Request $request, TahunPemerintahanKonfigurasi $tahun)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun_pemerintahan_konfigurasi,tahun,' . $tahun->id,
            'nama'  => 'nullable|string|max:255',
        ]);

        $tahun->update([
            ...$validated,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('tahun.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Hapus data
     */
    public function destroy(TahunPemerintahanKonfigurasi $tahun)
    {
        $tahun->delete();
        return redirect()->route('tahun.index')->with('success', 'Data berhasil dihapus.');
    }
}
