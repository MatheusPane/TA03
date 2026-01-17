<?php

namespace App\Http\Controllers;

use App\Models\DasawismaAnggota;
use App\Models\Dasawisma;
use App\Models\DataWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasawismaAnggotaController extends Controller
{
    // LIHAT ANGGOTA PER DASAWISMA
    public function index($dasawisma_id)
    {
        $dasawisma = Dasawisma::findOrFail($dasawisma_id);
        $anggota = DasawismaAnggota::with(['warga.pendidikan', 'warga.pekerjaan'])
            ->where('dasawisma_id', $dasawisma_id)
            ->get();

        return view('dasawisma_anggota.index', compact('dasawisma', 'anggota'));
    }

    // FORM TAMBAH ANGGOTA (dari dasawisma tertentu)
    public function create($dasawisma_id)
    {
        if (!Auth::user()->hasRole(['Admin', 'Pengurus'])) {
            abort(403);
        }

        $dasawisma = Dasawisma::findOrFail($dasawisma_id);
        // Hanya warga yang belum jadi anggota dasawisma lain
        $warga = DataWarga::whereDoesntHave('dasawismaAnggota')
            ->orWhereHas('dasawismaAnggota', function ($q) use ($dasawisma_id) {
                $q->where('dasawisma_id', $dasawisma_id);
            })
            ->get();

        return view('dasawisma_anggota.create', compact('dasawisma', 'warga'));
    }

    // SIMPAN ANGGOTA
    public function store(Request $request, $dasawisma_id)
    {
        if (!Auth::user()->hasRole(['Admin', 'Pengurus'])) {
            abort(403);
        }

        $request->validate([
            'warga_id' => 'required|exists:data_warga,id',
            'peran' => 'required|in:anggota,wakil ketua,sekretaris,bendahara',
        ]);

        DasawismaAnggota::create([
            'dasawisma_id' => $dasawisma_id,
            'warga_id' => $request->warga_id,
            'peran' => $request->peran,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('dasawisma_anggota.index', $dasawisma_id)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }
    public function edit($id)
{
    if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Pengurus'))  {
        abort(403);
    }

    $anggota = DasawismaAnggota::with('dasawisma', 'warga')->findOrFail($id);

    return view('dasawisma_anggota.edit', compact('anggota'));
}

public function update(Request $request, $id)
{
    if (!Auth::user()->hasRole(['Admin', 'Pengurus'])) {
        abort(403);
    }

    $anggota = DasawismaAnggota::findOrFail($id);

    $validated = $request->validate([
        'peran' => 'required|in:anggota,wakil ketua,sekretaris,bendahara',
    ]);

    $validated['updated_by'] = Auth::id();
    $anggota->update($validated);

    return redirect()
        ->route('dasawisma_anggota.index', $anggota->dasawisma_id)
        ->with('success', 'Peran anggota berhasil diperbarui.');
}
    // HAPUS ANGGOTA
    public function destroy($dasawisma_id, $id) // UBAH JADI 2 PARAMETER!
{
    if (!Auth::user()->hasRole('Admin')) {
        abort(403);
    }

    $anggota = DasawismaAnggota::findOrFail($id);
    
    // Pastikan anggota benar-benar milik dasawisma ini (keamanan)
    if ($anggota->dasawisma_id != $dasawisma_id) {
        abort(404);
    }

    $anggota->delete();

    return redirect()
        ->route('dasawisma_anggota.index', $dasawisma_id)
        ->with('success', 'Anggota berhasil dihapus.');
}
    
}