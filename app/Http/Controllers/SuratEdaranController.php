<?php
// app/Http/Controllers/SuratEdaranController.php

namespace App\Http\Controllers;

use App\Models\SuratEdaran;
use App\Models\Dusun;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SuratEdaranController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $surat = SuratEdaran::with(['creator', 'dusun', 'jabatan'])->active()->latest()->get();
        return view('surat_edaran.index', compact('surat'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $nomorOtomatis = $this->generateNomorOtomatis();
        $dusun = Dusun::active()->orderBy('nama')->get();
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_edaran.create', compact('nomorOtomatis', 'dusun', 'jabatan'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $request->validate([
            'nomor' => 'required|unique:surat_edarans,nomor',
            'tentang' => 'required|string',
            'poin_1' => 'required|string',
            'poin_2' => 'required|string',
            'poin_3' => 'required|string',
            'poin_4' => 'required|string',
            'dikeluarkan_di' => 'required|exists:dusun,id',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
        ]);

        $data = $request->only([
            'nomor', 'tentang', 'poin_1', 'poin_2', 'poin_3', 'poin_4',
            'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id'
        ]);
        $data['created_by'] = $data['updated_by'] = Auth::id();

        SuratEdaran::create($data);

        return redirect()->route('surat-edaran.index')->with('success', 'Surat Edaran berhasil dibuat!');
    }

    public function show(SuratEdaran $suratEdaran)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $suratEdaran->load(['dusun', 'jabatan']);
        return view('surat_edaran.show', compact('suratEdaran'));
    }

    public function edit(SuratEdaran $suratEdaran)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $dusun = Dusun::active()->orderBy('nama')->get();
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_edaran.edit', compact('suratEdaran', 'dusun', 'jabatan'));
    }

    public function update(Request $request, SuratEdaran $suratEdaran)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $request->validate([
            'nomor' => 'required|unique:surat_edarans,nomor,' . $suratEdaran->id,
            'tentang' => 'required|string',
            'poin_1' => 'required|string',
            'poin_2' => 'required|string',
            'poin_3' => 'required|string',
            'poin_4' => 'required|string',
            'dikeluarkan_di' => 'required|exists:dusun,id',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
        ]);

        $data = $request->only([
            'nomor', 'tentang', 'poin_1', 'poin_2', 'poin_3', 'poin_4',
            'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id'
        ]);
        $data['updated_by'] = Auth::id();

        $suratEdaran->update($data);

        return redirect()->route('surat-edaran.index')->with('success', 'Surat Edaran diperbarui!');
    }

    public function destroy(SuratEdaran $suratEdaran)
    {
        $this->authorizeRole(['Admin']);
        $suratEdaran->update(['active' => false]);
        $suratEdaran->delete();
        return redirect()->route('surat-edaran.index')->with('success', 'Surat diarsipkan!');
    }

    public function cetak(SuratEdaran $suratEdaran)
    {
        $this->authorizeRole(['Admin', 'Kader']);
        $suratEdaran->load(['dusun', 'jabatan']);
        $pdf = Pdf::loadView('surat_edaran.pdf', compact('suratEdaran'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Surat-Edaran-' . Str::slug($suratEdaran->nomor) . '.pdf');
    }

    private function generateNomorOtomatis()
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');
        $last = SuratEdaran::whereYear('created_at', $tahun)
            ->where('nomor', 'like', "E/%/PKK/{$bulan}/{$tahun}")
            ->max('nomor');

        if (!$last) {
            return "E/001/PKK/{$bulan}/{$tahun}";
        }

        preg_match('/E\/(\d+)\/PKK\/' . $bulan . '\/' . $tahun . '/', $last, $matches);
        $next = str_pad(($matches[1] ?? 0) + 1, 3, '0', STR_PAD_LEFT);
        return "E/{$next}/PKK/{$bulan}/{$tahun}";
    }

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Akses ditolak.');
        }
    }
}