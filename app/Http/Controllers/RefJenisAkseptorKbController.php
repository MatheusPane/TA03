<?php

namespace App\Http\Controllers;

use App\Models\RefJenisAkseptorKb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefJenisAkseptorKbController extends Controller
{
    public function index()
    {
        $akseptorList = RefJenisAkseptorKb::latest()->get();
        return view('ref_jenis_akseptor_kb.index', compact('akseptorList'));
    }

    public function create()
    {
        return view('ref_jenis_akseptor_kb.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_akseptor_kb,nama',
        ]);

        RefJenisAkseptorKb::create([
            'nama' => $request->nama,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_akseptor_kb.index')->with('success', 'Jenis Akseptor KB berhasil ditambahkan');
    }

    public function edit(RefJenisAkseptorKb $ref_jenis_akseptor_kb)
    {
        return view('ref_jenis_akseptor_kb.edit', compact('ref_jenis_akseptor_kb'));
    }

    public function update(Request $request, RefJenisAkseptorKb $ref_jenis_akseptor_kb)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:ref_jenis_akseptor_kb,nama,' . $ref_jenis_akseptor_kb->id,
        ]);

        $ref_jenis_akseptor_kb->update([
            'nama' => $request->nama,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('ref_jenis_akseptor_kb.index')->with('success', 'Jenis Akseptor KB berhasil diperbarui');
    }

    public function destroy(RefJenisAkseptorKb $ref_jenis_akseptor_kb)
    {
        $ref_jenis_akseptor_kb->delete();
        return redirect()->route('ref_jenis_akseptor_kb.index')->with('success', 'Jenis Akseptor KB berhasil dihapus');
    }
}
