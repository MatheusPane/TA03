<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\KegiatanWarga;
use App\Models\RefKegiatanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanWargaController extends Controller
{
    public function index($warga_id)
{
    $this->authorizeRole(['Admin', 'Kader']);
    $warga = DataWarga::findOrFail($warga_id);
    
    // Load semua referensi + data warga (jika sudah ada)
    $refKegiatan = RefKegiatanWarga::where('active', true)->orderBy('nama')->get();
    
    $kegiatanWarga = $warga->kegiatanWarga()
        ->with('refKegiatan')
        ->get()
        ->keyBy('ref_kegiatan_id');

    return view('kegiatan_warga.index', compact('warga', 'refKegiatan', 'kegiatanWarga'));
}
    public function dashboard()
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $wargaList = DataWarga::withCount([
            'kegiatanWarga as kegiatan_aktif_count' => function($q) {
                $q->where('ikut', true);
            }
        ])
        ->latest()
        ->paginate(15);

        $hasRefKegiatan = \App\Models\RefKegiatanWarga::exists();

        return view('kegiatan_warga.dashboard', compact('wargaList', 'hasRefKegiatan'));
    }

    public function create($warga_id)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $warga = DataWarga::findOrFail($warga_id);
        $refKegiatan = RefKegiatanWarga::where('active', true)->orderBy('nama')->get();

        return view('kegiatan_warga.create', compact('warga', 'refKegiatan'));
    }

    public function store(Request $request, $warga_id)
{
    $this->authorizeRole(['Admin', 'Kader']);

    $request->validate([
        'ref_kegiatan_id' => 'required|exists:ref_kegiatan_warga,id',
        'ikut' => 'required|boolean',
        'keterangan' => 'nullable|string'
    ]);

    KegiatanWarga::updateOrCreate(
        ['warga_id' => $warga_id, 'ref_kegiatan_id' => $request->ref_kegiatan_id],
        [
            'ikut' => $request->ikut,
            'keterangan' => $request->keterangan,
            'updated_by' => Auth::id()
        ]
    );

    return response()->json(['success' => true, 'message' => 'Disimpan']);
}

    public function edit($warga_id, $id)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $warga = DataWarga::findOrFail($warga_id);
        $kegiatan = KegiatanWarga::where('warga_id', $warga_id)->findOrFail($id);
        $refKegiatan = RefKegiatanWarga::where('active', true)->get();

        return view('kegiatan_warga.edit', compact('warga', 'kegiatan', 'refKegiatan'));
    }

    public function update(Request $request, $warga_id, $id)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $request->validate([
            'ikut' => 'required|boolean',
            'keterangan' => 'nullable|string'
        ]);

        $kegiatan = KegiatanWarga::where('warga_id', $warga_id)->findOrFail($id);
        $kegiatan->update([
            'ikut' => $request->ikut,
            'keterangan' => $request->keterangan,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('kegiatan_warga.index', $warga_id)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($warga_id, $id)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $kegiatan = KegiatanWarga::where('warga_id', $warga_id)->findOrFail($id);
        $kegiatan->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403);
        }
    }
}