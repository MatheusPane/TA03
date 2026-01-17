<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\Dusun;
use App\Models\Dasawisma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);
        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all();
        return view('data_keluarga.create', compact('dusun', 'dasawisma'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        $validated = $request->validate([
            'no_kk' => 'required|string|max:20|unique:data_keluarga,no_kk',
            'dusun_id' => 'required|exists:dusun,id',
            'dasawisma_id' => 'nullable|exists:dasawisma,id',
        ]);

        $keluarga = DataKeluarga::create($validated + ['created_by' => Auth::id()]);

        // Buat detail kosong otomatis
        $keluarga->detail()->create([
            'makanan_pokok' => 'Beras',
            'kriteria_rumah' => 'Kurang Sehat',
            'jumlah_kk' => 1,
            'is_manual' => false, // otomatis
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

    // Hanya update statistik jika detail BELUM diisi manual
    if ($keluarga->detail && !$keluarga->detail->is_manual) {
        $this->updateStatistik($keluarga);
    }

    return view('data_keluarga.show', compact('keluarga'));
}
    public function edit($id)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);
        $keluarga = DataKeluarga::findOrFail($id);
        $dusun = Dusun::all();
        $dasawisma = Dasawisma::all();
        return view('data_keluarga.edit', compact('keluarga', 'dusun', 'dasawisma'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

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
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

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
        // Jangan update jika sudah diisi manual
        if ($keluarga->detail && $keluarga->detail->is_manual) {
            return;
        }

        // Load relasi kebutuhanKhusus agar tidak null
        $anggota = $keluarga->anggotaKeluarga()
            ->with('warga.kebutuhanKhusus')
            ->get();

        $laki = 0;
        $perempuan = 0;
        $balita = 0;
        $kebutuhanKhusus = 0;

        foreach ($anggota as $a) {
            if (!$a->warga) continue;

            // Hitung jenis kelamin
            if ($a->warga->jenis_kelamin === 'L') $laki++;
            else $perempuan++;

            // Hitung umur untuk balita
            if ($a->warga->tanggal_lahir) {
                $umur = Carbon::parse($a->warga->tanggal_lahir)->age;
                if ($umur < 5) $balita++;
            }

            // BERKEBUTUHAN KHUSUS — INI YANG BENAR & PASTI TERDETEKSI
            if ($a->warga->kebutuhanKhusus) {  // <-- pakai relasi, bukan kolom id langsung
                $kebutuhanKhusus++;
            }
        }

        // Hitung yang lain
        $pus = $anggota->filter(fn($a) => $a->warga && $a->warga->isPus())->count();
        $wus = $anggota->filter(fn($a) => $a->warga && $a->warga->isWus())->count();
        $buta = $anggota->filter(fn($a) => $a->warga && optional($a->warga)->cacat && str_contains($a->warga->cacat, 'Buta'))->count();
        $ibuHamil = $anggota->filter(fn($a) => $a->warga && $a->warga->status_kehamilan === 'Hamil')->count();
        $ibuMenyusui = $anggota->filter(fn($a) => $a->warga && $a->warga->status_kehamilan === 'Menyusui')->count();
        $lansia = $anggota->filter(fn($a) => $a->warga && $a->warga->tanggal_lahir && Carbon::parse($a->warga->tanggal_lahir)->age >= 60)->count();

        $detail = $keluarga->detail ?? $keluarga->detail()->create([
            'makanan_pokok' => 'Beras',
            'kriteria_rumah' => 'Kurang Sehat',
            'jumlah_kk' => 1,
            'is_manual' => false,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        $detail->update([
            'jumlah_anggota'     => $anggota->count(),
            'laki_laki'          => $laki,
            'perempuan'          => $perempuan,
            'balita'             => $balita,
            'kebutuhan_khusus'   => $kebutuhanKhusus,   // SEKARANG PASTI TERISI!
            'pus'                => $pus,
            'wus'                => $wus,
            'buta'               => $buta,
            'ibu_hamil'          => $ibuHamil,
            'ibu_menyusui'       => $ibuMenyusui,
            'lansia'             => $lansia,
            'updated_by'         => Auth::id(),
            'is_manual'          => false,
        ]);
    }

    public function printDasawisma($id)
    {
        $keluarga = DataKeluarga::with([
            'detail',
            'anggotaKeluarga.warga.kebutuhanKhusus',  // PASTIKAN RELASI INI DI-LOAD
            'dusun',
            'dasawisma',
            'createdBy',
            'updatedBy'
        ])->findOrFail($id);

        // SELALU UPDATE STATISTIK SEBELUM PRINT (biar data lama juga ikut terupdate)
        $this->updateStatistik($keluarga);
        $keluarga->load('detail'); // refresh detail setelah update

        // Konfigurasi desa
        $config = \App\Models\DesaKonfigurasi::first();
        $namaDesa = \App\Models\DesaKonfigurasi::where('key', 'nama_desa')->first();
        $kecamatan = \App\Models\DesaKonfigurasi::where('key', 'kecamatan')->first();
        $kabupaten = \App\Models\DesaKonfigurasi::where('key', 'kabupaten')->first();

        return view('data_keluarga.print_dasawisma', compact(
            'keluarga',
            'config',
            'namaDesa',
            'kecamatan',
            'kabupaten'
        ));
}

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}