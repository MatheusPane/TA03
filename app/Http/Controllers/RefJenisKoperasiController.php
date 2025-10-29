<?php

namespace App\Http\Controllers;

use App\Models\RefJenisKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefJenisKoperasiController extends Controller
{
    public function index()
    {
        $koperasiList = RefJenisKoperasi::latest()->get();
        return view('ref_jenis_koperasi.index', compact('koperasiList'));
    }

    public function create()
    {
        return view('ref_jenis_koperasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_koperasi,nama',
        ]);

        RefJenisKoperasi::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_koperasi.index')->with('success', 'Jenis Koperasi berhasil ditambahkan');
    }

    public function edit(RefJenisKoperasi $ref_jenis_koperasi)
    {
        return view('ref_jenis_koperasi.edit', compact('ref_jenis_koperasi'));
    }

    public function update(Request $request, RefJenisKoperasi $ref_jenis_koperasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_koperasi,nama,' . $ref_jenis_koperasi->id,
        ]);

        $ref_jenis_koperasi->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_koperasi.index')->with('success', 'Jenis Koperasi berhasil diperbarui');
    }

    public function destroy(RefJenisKoperasi $ref_jenis_koperasi)
    {
        $ref_jenis_koperasi->delete();
        return redirect()->route('ref_jenis_koperasi.index')->with('success', 'Jenis Koperasi berhasil dihapus');
    }
}
