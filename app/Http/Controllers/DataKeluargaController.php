<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\Dusun;
use App\Models\Dasawisma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluargaController extends Controller
{
    public function index()
    {
        $dataKeluarga = DataKeluarga::with([
            'dusun',
            'dasawisma',
            'detail'
        ])->withCount(['anggotaKeluarga as laki_count' => function ($q) {
            $q->whereHas('warga', fn($q) => $q->where('jenis_kelamin', 'L'));
        }, 'anggotaKeluarga as perempuan_count' => function ($q) {
            $q->whereHas('warga', fn($q) => $q->where('jenis_kelamin', 'P'));
        }])
        ->latest()
        ->get();

        return view('data_keluarga.index', compact('dataKeluarga'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all();
        return view('data_keluarga.create', compact('dusun', 'dasawisma'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:data_keluarga,no_kk',
            'dusun_id' => 'required|exists:dusun,id',
            'dasawisma_id' => 'nullable|exists:dasawisma,id',
        ]);

        $keluarga = DataKeluarga::create($validated + ['created_by' => Auth::id()]);

        // Buat detail kosong otomatis
        $keluarga->detail()->create([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('data_keluarga.index')
            ->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    public function show($id)
    {
        $keluarga = DataKeluarga::with([
            'dusun', 'dasawisma',
            'detail.makananPokokLain', 'detail.sumberAir', 'detail.jenisUsaha',
            'anggotaKeluarga.warga.statusPerkawinan',
            'anggotaKeluarga.warga.pendidikan',
            'anggotaKeluarga.warga.pekerjaan',
            'anggotaKeluarga.statusDalamKeluarga',
            'createdBy', 'updatedBy'
        ])->findOrFail($id);
    
        // JANGAN BUAT DETAIL KOSONG DI SINI
        // Hanya update statistik jika detail sudah ada
        if ($keluarga->detail) {
            $this->updateStatistik($keluarga);
        }
    
        return view('data_keluarga.show', compact('keluarga'));
    }
    public function edit($id)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $keluarga = DataKeluarga::findOrFail($id);
        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all();
        return view('data_keluarga.edit', compact('keluarga', 'dusun', 'dasawisma'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:data_keluarga,no_kk,' . $id,
            'dusun_id' => 'required|exists:dusun,id',
            'dasawisma_id' => 'nullable|exists:dasawisma,id',
        ]);

        $keluarga = DataKeluarga::findOrFail($id);
        $keluarga->update($validated + ['updated_by' => Auth::id()]);

        return redirect()->route('data_keluarga.index')
            ->with('success', 'Data keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeRole(['Admin']);

        $keluarga = DataKeluarga::findOrFail($id);

        if ($keluarga->anggotaKeluarga()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus keluarga yang memiliki anggota.');
        }

        $keluarga->detail()->delete();
        $keluarga->delete();

        return redirect()->route('data_keluarga.index')
            ->with('success', 'Data keluarga berhasil dihapus.');
    }

    private function updateStatistik($keluarga)
    {
        $anggota = $keluarga->anggotaKeluarga()->with('warga')->get();
        $laki = $anggota->where('warga.jenis_kelamin', 'L')->count();
        $perempuan = $anggota->count() - $laki;

        $detail = $keluarga->detail ?? $keluarga->detail()->create([]);
        $detail->update([
            'jumlah_anggota' => $anggota->count(),
            'laki_laki' => $laki,
            'perempuan' => $perempuan,
            'updated_by' => Auth::id(),
        ]);
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}