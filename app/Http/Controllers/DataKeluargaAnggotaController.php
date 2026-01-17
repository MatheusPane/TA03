<?php
namespace App\Http\Controllers;

use App\Models\DataKeluargaAnggota;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\RefStatusDalamKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluargaAnggotaController extends Controller
{
    public function index($keluarga_id)
    {
        $keluarga = DataKeluarga::findOrFail($keluarga_id);
        $anggotaKeluarga = DataKeluargaAnggota::with([
            'keluarga',
            'warga.pendidikan',
            'warga.pekerjaan',
            'statusDalamKeluarga',
            'createdBy',
            'updatedBy'
        ])->where('keluarga_id', $keluarga_id)->get();
    
        return view('data_keluarga_anggota.index', compact('keluarga', 'anggotaKeluarga'));
    
    }

    public function create($keluarga_id)
{
    if (! (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')) ) {
        abort(403, 'Anda tidak memiliki izin untuk menambahkan anggota keluarga.');
    }

    $keluarga = DataKeluarga::findOrFail($keluarga_id);
    $status = RefStatusDalamKeluarga::all();
    $warga = DataWarga::with(['pendidikan', 'pekerjaan'])->get();

    return view('data_keluarga_anggota.create', compact('keluarga', 'status', 'warga'));
}

    public function store(Request $request)
    {
        if (! (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')) ) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan data.');
        }

        $validated = $request->validate([
            'keluarga_id' => 'required|exists:data_keluarga,id',
            'warga_id' => 'required|exists:data_warga,id',
            'status_dalam_keluarga_id' => 'required|exists:ref_status_dalam_keluarga,id',
        ]);

        $validated['created_by'] = Auth::id();

        DataKeluargaAnggota::create($validated);

        return redirect()->route('data_keluarga_anggota.index', $validated['keluarga_id'])
            ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (! (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')) ) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data keluarga.');
        }

        $anggota = DataKeluargaAnggota::findOrFail($id);
        $keluarga = DataKeluarga::all();
        $status = RefStatusDalamKeluarga::all();
        $warga = DataWarga::with(['pendidikan', 'pekerjaan'])->get();

        return view('data_keluarga_anggota.edit', compact('anggota', 'keluarga', 'status', 'warga'));
    }

    public function update(Request $request, $id)
    {
        if (! (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')) ) {
            abort(403, 'Anda tidak memiliki izin untuk mengupdate data.');
        }

        $validated = $request->validate([
            'keluarga_id' => 'required|exists:data_keluarga,id',
            'warga_id' => 'required|exists:data_warga,id',
            'status_dalam_keluarga_id' => 'required|exists:ref_status_dalam_keluarga,id',
        ]);

        $validated['updated_by'] = Auth::id();

        $anggota = DataKeluargaAnggota::findOrFail($id);
        $anggota->update($validated);

        return redirect()->route('data_keluarga_anggota.index', $validated['keluarga_id'])
            ->with('success', 'Data anggota keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (! (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader') || Auth::user()->hasRole('Pengurus')) ) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data.');
        }
        $anggota = DataKeluargaAnggota::findOrFail($id);
        $keluarga_id = $anggota->keluarga_id;
        $anggota->delete();

        return redirect()->route('data_keluarga_anggota.index', $keluarga_id)
            ->with('success', 'Anggota keluarga berhasil dihapus.');
    }
}