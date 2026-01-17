<?php

namespace App\Http\Controllers;

use App\Models\SuratBiasa;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SuratBiasaController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $surat = SuratBiasa::with(['creator', 'jabatan'])->active()->latest()->get();
        return view('surat_biasa.index', compact('surat'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $nomorOtomatis = $this->generateNomorOtomatis();
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_biasa.create', compact('nomorOtomatis', 'jabatan'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);

        $request->validate([
            'nomor' => 'required|unique:surat_biasas,nomor',
            'lampiran' => 'nullable|string',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'di' => 'required|string',
            'tanggal' => 'required|date', // TAMBAH VALIDASI!
            'kata_pembuka' => 'required|string',
            'isi_surat' => 'required|string',
            'penutup' => 'required|string',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'lampiran', 'perihal', 'kepada', 'di',
            'tanggal', // SUDAH ADA
            'kata_pembuka', 'isi_surat', 'penutup',
            'nama_penanda_tangan', 'jabatan_id'
        ]);

        $data['created_by'] = $data['updated_by'] = Auth::id();
        $data['tembusan'] = array_filter($request->tembusan ?? []);

        SuratBiasa::create($data);

        return redirect()
            ->route('surat-biasa.index')
            ->with('success', 'Surat Biasa berhasil dibuat!');
    }

    public function show(SuratBiasa $suratBiasa)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $suratBiasa->load(['creator', 'jabatan']);
        return view('surat_biasa.show', compact('suratBiasa'));
    }

    public function edit(SuratBiasa $suratBiasa)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_biasa.edit', compact('suratBiasa', 'jabatan'));
    }

    public function update(Request $request, SuratBiasa $suratBiasa)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);

        $request->validate([
            'nomor' => 'required|unique:surat_biasas,nomor,' . $suratBiasa->id,
            'lampiran' => 'nullable|string',
            'perihal' => 'required|string',
            'kepada' => 'required|string',
            'di' => 'required|string',
            'tanggal' => 'required|date', // TAMBAH VALIDASI!
            'kata_pembuka' => 'required|string',
            'isi_surat' => 'required|string',
            'penutup' => 'required|string',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'lampiran', 'perihal', 'kepada', 'di',
            'tanggal', // TAMBAH DI SINI!
            'kata_pembuka', 'isi_surat', 'penutup',
            'nama_penanda_tangan', 'jabatan_id'
        ]);

        $data['updated_by'] = Auth::id();
        $data['tembusan'] = array_filter($request->tembusan ?? []);

        $suratBiasa->update($data);

        return redirect()
            ->route('surat-biasa.index')
            ->with('success', 'Surat Biasa diperbarui!');
    }

    public function destroy(SuratBiasa $suratBiasa)
    {
        $this->authorizeRole(['Admin']); // HANYA ADMIN BOLEH HAPUS
        $suratBiasa->update(['active' => false]);
        $suratBiasa->delete();

        return redirect()
            ->route('surat-biasa.index')
            ->with('success', 'Surat diarsipkan!');
    }

    public function cetak(SuratBiasa $suratBiasa)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $suratBiasa->load('jabatan');
        $pdf = Pdf::loadView('surat_biasa.pdf', compact('suratBiasa'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Surat-Biasa-' . Str::slug($suratBiasa->nomor) . '.pdf');
    }

    private function generateNomorOtomatis()
    {
        $tahun = now()->format('Y');
        $last = SuratBiasa::whereYear('created_at', $tahun)
            ->where('nomor', 'like', "%/Skr/PKK/%/{$tahun}")
            ->max('nomor');

        if (!$last) {
            return "001/Skr/PKK/01/{$tahun}";
        }

        preg_match('/(\d+)\/Skr\/PKK\/(\d+)\/' . $tahun . '/', $last, $matches);
        $next = str_pad(($matches[1] ?? 0) + 1, 3, '0', STR_PAD_LEFT);
        $bulan = $matches[2] ?? '01';
        return "{$next}/Skr/PKK/{$bulan}/{$tahun}";
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}