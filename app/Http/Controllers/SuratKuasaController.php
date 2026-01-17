<?php
// app/Http/Controllers/SuratKuasaController.php

namespace App\Http\Controllers;

use App\Models\SuratKuasa;
use App\Models\DataWarga;
use App\Models\Dusun;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SuratKuasaController extends Controller
{
    public function index()
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    
    $surat = SuratKuasa::with([
        'pemberiKuasa.jabatan',
        'penerimaKuasa.jabatan',
        'dusun',
        'jabatan'
    ])->active()->latest()->get();

    return view('surat_kuasa.index', compact('surat'));
}

    public function create()
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $nomorOtomatis = $this->generateNomorOtomatis();

    // HAPUS 'dusun' DARI with() → karena tidak ada relasi
    $warga = DataWarga::with('jabatan')->active()->orderBy('nama')->get();
    $dusun = Dusun::active()->orderBy('nama')->get();
    $jabatan = RefJabatan::active()->orderBy('nama')->get();

    return view('surat_kuasa.create', compact('nomorOtomatis', 'warga', 'dusun', 'jabatan'));
}

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $request->validate([
            'nomor' => 'required|unique:surat_kuasas,nomor',
            'pemberi_kuasa_id' => 'required|exists:data_warga,id',
            'penerima_kuasa_id' => 'required|exists:data_warga,id',
            'untuk' => 'required|string',
            'dikeluarkan_di' => 'required|exists:dusun,id',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'pemberi_kuasa_id', 'penerima_kuasa_id', 'untuk',
            'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id', 'tembusan'
        ]);
        $data['tembusan'] = array_filter($request->tembusan ?? []);
        $data['created_by'] = $data['updated_by'] = Auth::id();

        SuratKuasa::create($data);

        return redirect()->route('surat-kuasa.index')->with('success', 'Surat Kuasa berhasil dibuat!');
    }

    public function show(SuratKuasa $suratKuasa)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    
    // HAPUS .dusun → karena tidak ada relasi di DataWarga
    $suratKuasa->load([
        'pemberiKuasa.jabatan',
        'penerimaKuasa.jabatan',
        'dusun',    // ini dari dikeluarkan_di
        'jabatan'
    ]);

    return view('surat_kuasa.show', compact('suratKuasa'));
}

    public function edit(SuratKuasa $suratKuasa)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    
    // HAPUS 'dusun' dari with()
    $warga = DataWarga::with('jabatan')->active()->orderBy('nama')->get();
    $dusun = Dusun::active()->orderBy('nama')->get();
    $jabatan = RefJabatan::active()->orderBy('nama')->get();

    return view('surat_kuasa.edit', compact('suratKuasa', 'warga', 'dusun', 'jabatan'));
}

    public function update(Request $request, SuratKuasa $suratKuasa)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $request->validate([
            'nomor' => 'required|unique:surat_kuasas,nomor,' . $suratKuasa->id,
            'pemberi_kuasa_id' => 'required|exists:data_warga,id',
            'penerima_kuasa_id' => 'required|exists:data_warga,id',
            'untuk' => 'required|string',
            'dikeluarkan_di' => 'required|exists:dusun,id',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'pemberi_kuasa_id', 'penerima_kuasa_id', 'untuk',
            'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id', 'tembusan'
        ]);
        $data['tembusan'] = array_filter($request->tembusan ?? []);
        $data['updated_by'] = Auth::id();

        $suratKuasa->update($data);

        return redirect()->route('surat-kuasa.index')->with('success', 'Surat Kuasa diperbarui!');
    }

    public function destroy(SuratKuasa $suratKuasa)
    {
        $this->authorizeRole(['Admin']);
        $suratKuasa->update(['active' => false]);
        $suratKuasa->delete();
        return redirect()->route('surat-kuasa.index')->with('success', 'Surat diarsipkan!');
    }

    public function cetak(SuratKuasa $suratKuasa)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    
    // Load hanya relasi yang ada
    $suratKuasa->load([
        'pemberiKuasa.jabatan',
        'penerimaKuasa.jabatan',
        'dusun',
        'jabatan'
    ]);

    $pdf = Pdf::loadView('surat_kuasa.pdf', compact('suratKuasa'))
              ->setPaper('a4', 'portrait');
    return $pdf->stream('Surat-Kuasa-' . Str::slug($suratKuasa->nomor) . '.pdf');
}

    private function generateNomorOtomatis()
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');
        $last = SuratKuasa::whereYear('created_at', $tahun)
            ->where('nomor', 'like', "%/SK/PKK/{$bulan}/{$tahun}")
            ->max('nomor');

        if (!$last) {
            return "001/SK/PKK/{$bulan}/{$tahun}";
        }

        preg_match('/(\d+)\/SK\/PKK\/' . $bulan . '\/' . $tahun . '/', $last, $matches);
        $next = str_pad(($matches[1] ?? 0) + 1, 3, '0', STR_PAD_LEFT);
        return "{$next}/SK/PKK/{$bulan}/{$tahun}";
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Akses ditolak.');
        }
    }
}