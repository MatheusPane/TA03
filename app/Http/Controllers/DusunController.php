<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\TahunPemerintahanKonfigurasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DusunController extends Controller
{
    /**
     * Tampilkan daftar semua dusun.
     */
    public function index()
    {
        $dusunList = Dusun::with('tahunKonfigurasi')->latest()->get();

        return view('dusun.index', compact('dusunList'));
    }

    /**
     * Form tambah dusun baru.
     */
    public function create()
    {
        $tahunList = TahunPemerintahanKonfigurasi::where('active', true)->orderByDesc('tahun')->get();

        return view('dusun.create', compact('tahunList'));
    }

    /**
     * Simpan dusun baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_konfigurasi_id' => 'required|exists:tahun_pemerintahan_konfigurasi,id',
        ]);

        Dusun::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil ditambahkan.');
    }

    /**
     * Form edit dusun.
     */
    public function edit(Dusun $dusun)
    {
        $tahunList = TahunPemerintahanKonfigurasi::where('active', true)->orderByDesc('tahun')->get();

        return view('dusun.edit', compact('dusun', 'tahunList'));
    }

    /**
     * Update data dusun.
     */
    public function update(Request $request, Dusun $dusun)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun_konfigurasi_id' => 'required|exists:tahun_pemerintahan_konfigurasi,id',
        ]);

        $dusun->update([
            ...$validated,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil diperbarui.');
    }

    /**
     * Hapus dusun.
     */
    public function destroy(Dusun $dusun)
    {
        $dusun->delete();

        return redirect()->route('dusun.index')->with('success', 'Dusun berhasil dihapus.');
    }
}
