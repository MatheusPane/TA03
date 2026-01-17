<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use App\Models\DataWarga;
use App\Models\Dusun;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
class SuratTugasController extends Controller
{
    // app/Http/Controllers/SuratTugasController.php
public function index()
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $surat = SuratTugas::with(['penerimaTugas.jabatan', 'dusun', 'jabatan'])->active()->latest()->get();
    return view('surat_tugas.index', compact('surat'));
}

public function create()
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $nomorOtomatis = $this->generateNomorOtomatis();
    $warga = DataWarga::with('jabatan')->active()->orderBy('nama')->get();
    $dusun = Dusun::active()->orderBy('nama')->get();
    $jabatan = RefJabatan::active()->orderBy('nama')->get();
    return view('surat_tugas.create', compact('nomorOtomatis', 'warga', 'dusun', 'jabatan'));
}

public function store(Request $request)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $request->validate([
        'nomor' => 'required|unique:surat_tugas,nomor',
        'dasar.*' => 'nullable|string',
        'penerima_tugas_id' => 'required|exists:data_warga,id',
        'untuk' => 'required|string',
        'hari_tanggal' => 'required|string',
        'waktu' => 'required|string',
        'tempat' => 'required|string',
        'dikeluarkan_di' => 'required|exists:dusun,id',
        'tanggal' => 'required|date',
        'nama_penanda_tangan' => 'required|string',
        'jabatan_id' => 'required|exists:ref_jabatan,id',
        'tembusan.*' => 'nullable|string',
    ]);

    $data = $request->only([
        'nomor', 'penerima_tugas_id', 'untuk', 'hari_tanggal', 'waktu', 'tempat',
        'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id', 'tembusan'
    ]);
    $data['dasar'] = array_filter($request->dasar ?? []);
    $data['tembusan'] = array_filter($request->tembusan ?? []);
    $data['created_by'] = $data['updated_by'] = Auth::id();

    SuratTugas::create($data);

    return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dibuat!');
}

public function show(SuratTugas $suratTuga)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $suratTuga->load(['penerimaTugas.jabatan', 'dusun', 'jabatan']);
    return view('surat_tugas.show', compact('suratTuga'));
}

public function edit(SuratTugas $suratTuga)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $warga = DataWarga::with('jabatan')->active()->orderBy('nama')->get();
    $dusun = Dusun::active()->orderBy('nama')->get();
    $jabatan = RefJabatan::active()->orderBy('nama')->get();
    return view('surat_tugas.edit', compact('suratTuga', 'warga', 'dusun', 'jabatan'));
}

public function update(Request $request, SuratTugas $suratTuga)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $request->validate([
        'nomor' => 'required|unique:surat_tugas,nomor,' . $suratTuga->id,
        'dasar.*' => 'nullable|string',
        'penerima_tugas_id' => 'required|exists:data_warga,id',
        'untuk' => 'required|string',
        'hari_tanggal' => 'required|string',
        'waktu' => 'required|string',
        'tempat' => 'required|string',
        'dikeluarkan_di' => 'required|exists:dusun,id',
        'tanggal' => 'required|date',
        'nama_penanda_tangan' => 'required|string',
        'jabatan_id' => 'required|exists:ref_jabatan,id',
        'tembusan.*' => 'nullable|string',
    ]);

    $data = $request->only([
        'nomor', 'penerima_tugas_id', 'untuk', 'hari_tanggal', 'waktu', 'tempat',
        'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id', 'tembusan'
    ]);
    $data['dasar'] = array_filter($request->dasar ?? []);
    $data['tembusan'] = array_filter($request->tembusan ?? []);
    $data['updated_by'] = Auth::id();

    $suratTuga->update($data);

    return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas diperbarui!');
}

public function destroy(SuratTugas $suratTuga)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $suratTuga->update(['active' => false]);
    $suratTuga->delete();
    return redirect()->route('surat-tugas.index')->with('success', 'Surat diarsipkan!');
}

// app/Http/Controllers/SuratTugasController.php
public function cetak(SuratTugas $suratTuga)
{
    $this->authorizeRole(['Admin', 'Pengurus']);

    // LOAD RELASI → WAJIB!
    $suratTuga->load([
        'penerimaTugas.jabatan',
        'dusun',
        'jabatan'
    ]);

    $pdf = Pdf::loadView('surat_tugas.pdf', compact('suratTuga'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('Surat-Tugas-' . Str::slug($suratTuga->nomor) . '.pdf');
}

private function generateNomorOtomatis()
{
    $tahun = now()->format('Y');
    $bulan = now()->format('m');
    $last = SuratTugas::whereYear('created_at', $tahun)
        ->where('nomor', 'like', "%/ST/PKK/{$bulan}/{$tahun}")
        ->max('nomor');

    if (!$last) return "001/ST/PKK/{$bulan}/{$tahun}";
    preg_match('/(\d+)\/ST\/PKK\/' . $bulan . '\/' . $tahun . '/', $last, $matches);
    $next = str_pad(($matches[1] ?? 0) + 1, 3, '0', STR_PAD_LEFT);
    return "{$next}/ST/PKK/{$bulan}/{$tahun}";
}

private function authorizeRole(array $roles)
{
    $user = Auth::user();
    if (!$user || !$user->hasRole($roles)) abort(403);
}
}
