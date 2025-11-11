<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\RefStatusPerkawinan;
use App\Models\RefAgama;
use App\Models\RefPendidikan;
use App\Models\RefPekerjaan;
use App\Models\RefJabatan;
use App\Models\RefJenisKoperasi;
use App\Models\RefJenisAkseptorKb;
use App\Models\RefJenisKelompokBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // ← WAJIB IMPORT

class DataWargaController extends Controller
{
    public function index()
    {
        $dataWarga = DataWarga::with([
            'jabatan',
            'statusPerkawinan',
            'agama',
            'pendidikan',
            'pekerjaan',
            'jenisKoperasi',
            'jenisAkseptorKb',
            'jenisKelompokBelajar',
            'createdBy',
            'updatedBy'
        ])->latest()->get();

        return view('data_warga.index', compact('dataWarga'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'Kader']);

        return view('data_warga.create', [
            'statusPerkawinan'     => RefStatusPerkawinan::all(),
            'agama'                => RefAgama::all(),
            'pendidikan'           => RefPendidikan::all(),
            'pekerjaan'            => RefPekerjaan::all(),
            'jabatan'              => RefJabatan::all(),
            'jenisKoperasi'        => RefJenisKoperasi::all(),
            'jenisAkseptorKb'      => RefJenisAkseptorKb::all(),
            'jenisKelompokBelajar' => RefJenisKelompokBelajar::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $validator = Validator::make($request->all(), [
            'no_registrasi'         => 'nullable|string|max:50|unique:data_warga,no_registrasi',
            'no_ktp'                => 'nullable|string|max:50|unique:data_warga,no_ktp',
            'nama'                  => 'required|string|max:255',
            'jabatan_id'            => 'nullable|exists:ref_jabatan,id',
            'jenis_kelamin'         => 'nullable|in:L,P',
            'tempat_lahir'          => 'nullable|string|max:255',
            'tanggal_lahir'         => 'nullable|date',
            'status_perkawinan_id'  => 'nullable|exists:ref_status_perkawinan,id',
            'agama_id'              => 'nullable|exists:ref_agama,id',
            'pendidikan_id'         => 'nullable|exists:ref_pendidikan,id',
            'pekerjaan_id'          => 'nullable|exists:ref_pekerjaan,id',
            'ikut_paud'             => 'required|in:ya,tidak',
            'memiliki_tabungan'     => 'required|in:ya,tidak',

            // === KELOMPOK BELAJAR ===
            'ikut_kelompok_belajar' => 'required|in:ya,tidak',
            'jenis_kelompok_belajar_id' => [
                'nullable',
                'exists:ref_jenis_kelompok_belajar,id',
                Rule::requiredIf($request->ikut_kelompok_belajar === 'ya'),
                Rule::prohibitedIf($request->ikut_kelompok_belajar === 'tidak'),
            ],

            // === AKSEPTOR KB ===
            'ikut_akseptor_kb' => 'required|in:ya,tidak',
            'jenis_akseptor_kb_id' => [
                'nullable',
                'exists:ref_jenis_akseptor_kb,id',
                Rule::requiredIf($request->ikut_akseptor_kb === 'ya'),
                Rule::prohibitedIf($request->ikut_akseptor_kb === 'tidak'),
            ],

            // === KOPERASI ===
            'ikut_koperasi' => 'required|in:ya,tidak',
            'jenis_koperasi_id' => [
                'nullable',
                'exists:ref_jenis_koperasi,id',
                Rule::requiredIf($request->ikut_koperasi === 'ya'),
                Rule::prohibitedIf($request->ikut_koperasi === 'tidak'),
            ],
        ], [
            // Pesan error custom
            'jenis_kelompok_belajar_id.prohibited' => 'Jenis kelompok belajar tidak boleh diisi jika tidak mengikuti kelompok belajar.',
            'jenis_akseptor_kb_id.prohibited'      => 'Jenis akseptor KB tidak boleh diisi jika bukan akseptor KB.',
            'jenis_koperasi_id.prohibited'         => 'Jenis koperasi tidak boleh diisi jika tidak ikut koperasi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['created_by'] = Auth::id();

        DataWarga::create($validated);

        return redirect()->route('data_warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $warga = DataWarga::findOrFail($id);

        return view('data_warga.edit', [
            'warga'                => $warga,
            'statusPerkawinan'     => RefStatusPerkawinan::all(),
            'agama'                => RefAgama::all(),
            'pendidikan'           => RefPendidikan::all(),
            'pekerjaan'            => RefPekerjaan::all(),
            'jabatan'              => RefJabatan::all(),
            'jenisKoperasi'        => RefJenisKoperasi::all(),
            'jenisAkseptorKb'      => RefJenisAkseptorKb::all(),
            'jenisKelompokBelajar' => RefJenisKelompokBelajar::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin', 'Kader']);

        $validator = Validator::make($request->all(), [
            'no_registrasi'         => 'nullable|string|max:50|unique:data_warga,no_registrasi,' . $id,
            'no_ktp'                => 'nullable|string|max:50|unique:data_warga,no_ktp,' . $id,
            'nama'                  => 'required|string|max:255',
            'jabatan_id'            => 'nullable|exists:ref_jabatan,id',
            'jenis_kelamin'         => 'nullable|in:L,P',
            'tempat_lahir'          => 'nullable|string|max:255',
            'tanggal_lahir'         => 'nullable|date',
            'status_perkawinan_id'  => 'nullable|exists:ref_status_perkawinan,id',
            'agama_id'              => 'nullable|exists:ref_agama,id',
            'pendidikan_id'         => 'nullable|exists:ref_pendidikan,id',
            'pekerjaan_id'          => 'nullable|exists:ref_pekerjaan,id',
            'ikut_paud'             => 'required|in:ya,tidak',
            'memiliki_tabungan'     => 'required|in:ya,tidak',

            'ikut_kelompok_belajar' => 'required|in:ya,tidak',
            'jenis_kelompok_belajar_id' => [
                'nullable',
                'exists:ref_jenis_kelompok_belajar,id',
                Rule::requiredIf($request->ikut_kelompok_belajar === 'ya'),
                Rule::prohibitedIf($request->ikut_kelompok_belajar === 'tidak'),
            ],

            'ikut_akseptor_kb' => 'required|in:ya,tidak',
            'jenis_akseptor_kb_id' => [
                'nullable',
                'exists:ref_jenis_akseptor_kb,id',
                Rule::requiredIf($request->ikut_akseptor_kb === 'ya'),
                Rule::prohibitedIf($request->ikut_akseptor_kb === 'tidak'),
            ],

            'ikut_koperasi' => 'required|in:ya,tidak',
            'jenis_koperasi_id' => [
                'nullable',
                'exists:ref_jenis_koperasi,id',
                Rule::requiredIf($request->ikut_koperasi === 'ya'),
                Rule::prohibitedIf($request->ikut_koperasi === 'tidak'),
            ],
        ], [
            'jenis_kelompok_belajar_id.prohibited' => 'Jenis kelompok belajar tidak boleh diisi jika tidak mengikuti kelompok belajar.',
            'jenis_akseptor_kb_id.prohibited'      => 'Jenis akseptor KB tidak boleh diisi jika bukan akseptor KB.',
            'jenis_koperasi_id.prohibited'         => 'Jenis koperasi tidak boleh diisi jika tidak ikut koperasi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['updated_by'] = Auth::id();

        $warga = DataWarga::findOrFail($id);
        $warga->update($validated);

        return redirect()->route('data_warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeRole(['Admin']);

        $warga = DataWarga::findOrFail($id);
        $warga->delete();

        return redirect()->route('data_warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
    public function show($id)
    {
    $this->authorizeRole(['Admin', 'Kader']);

    $warga = DataWarga::with([
        'jabatan', 'statusPerkawinan', 'agama', 'pendidikan', 'pekerjaan',
        'jenisKoperasi', 'jenisAkseptorKb', 'jenisKelompokBelajar',
        'createdBy', 'updatedBy', 'kegiatanWarga' => function($q) {
            $q->with('refKegiatan')->where('ikut', true);
        }
    ])->findOrFail($id);

    return view('data_warga.show', compact('warga'));
    }
    /**
     * Cek role pengguna
     */
    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}