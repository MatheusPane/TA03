<?php
// app/Http/Controllers/SuratKeputusanController.php

namespace App\Http\Controllers;

use App\Models\SuratKeputusan;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class SuratKeputusanController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $surat = SuratKeputusan::with(['creator', 'updater', 'jabatan'])
            ->active()
            ->latest()
            ->get();

        return view('surat_keputusan.index', compact('surat'));
    }

    public function create()
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $nomorOtomatis = $this->generateNomorOtomatis();
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_keputusan.create', compact('nomorOtomatis', 'jabatan'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $request->validate([
            'nomor' => 'required|unique:surat_keputusans,nomor',
            'tentang' => 'required|string|max:255',
            'menimbang' => 'nullable|string',
            'mengingat.*' => 'nullable|string',
            'memperhatikan' => 'nullable|string',
            'menetapkan.PERTAMA' => 'required|string',
            'menetapkan.KEDUA' => 'nullable|string',
            'menetapkan.KETIGA' => 'nullable|string',
            'ditetapkan_di' => 'required|string',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id', // VALIDASI ID!
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'tentang', 'menimbang', 'memperhatikan',
            'menetapkan', 'ditetapkan_di', 'tanggal',
            'nama_penanda_tangan', 'jabatan_id', 'tembusan'
        ]);

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['mengingat'] = array_filter($request->mengingat ?? []);
        $data['tembusan'] = array_filter($request->tembusan ?? []);

        SuratKeputusan::create($data);

        return redirect()
            ->route('surat_keputusan.index')
            ->with('success', 'Surat Keputusan berhasil dibuat!');
    }

    public function show(SuratKeputusan $suratKeputusan)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $suratKeputusan->load(['creator', 'updater', 'jabatan']);
        return view('surat_keputusan.show', compact('suratKeputusan'));
    }

    public function edit(SuratKeputusan $suratKeputusan)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $jabatan = RefJabatan::active()->orderBy('nama')->get();
        return view('surat_keputusan.edit', compact('suratKeputusan', 'jabatan'));
    }

    public function update(Request $request, SuratKeputusan $suratKeputusan)
    {
        $this->authorizeRole(['Admin', 'Pengurus']);
        $request->validate([
            'nomor' => 'required|unique:surat_keputusans,nomor,' . $suratKeputusan->id,
            'tentang' => 'required|string|max:255',
            'menimbang' => 'nullable|string',
            'mengingat.*' => 'nullable|string',
            'memperhatikan' => 'nullable|string',
            'menetapkan.PERTAMA' => 'required|string',
            'menetapkan.KEDUA' => 'nullable|string',
            'menetapkan.KETIGA' => 'nullable|string',
            'ditetapkan_di' => 'required|string',
            'tanggal' => 'required|date',
            'nama_penanda_tangan' => 'required|string',
            'jabatan_id' => 'required|exists:ref_jabatan,id',
            'tembusan.*' => 'nullable|string',
        ]);

        $data = $request->only([
            'nomor', 'tentang', 'menimbang', 'memperhatikan',
            'menetapkan', 'ditetapkan_di', 'tanggal',
            'nama_penanda_tangan', 'jabatan_id', 'tembusan'
        ]);

        $data['updated_by'] = Auth::id();
        $data['mengingat'] = array_filter($request->mengingat ?? []);
        $data['tembusan'] = array_filter($request->tembusan ?? []);

        $suratKeputusan->update($data);

        return redirect()
            ->route('surat_keputusan.index')
            ->with('success', 'Surat Keputusan berhasil diperbarui!');
    }

    public function destroy(SuratKeputusan $suratKeputusan)
{
    $this->authorizeRole(['Admin', 'Pengurus']);
    $suratKeputusan->forceDelete();

    return redirect()
        ->route('surat_keputusan.index')
        ->with('success', 'Surat Keputusan berhasil dihapus permanen!');
}

    public function cetak(SuratKeputusan $suratKeputusan)
    {
        $suratKeputusan->load('jabatan'); // Load jabatan untuk PDF
        $pdf = Pdf::loadView('surat_keputusan.pdf', compact('suratKeputusan'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('SK-PKK-' . Str::slug($suratKeputusan->nomor) . '.pdf');
    }

    private function generateNomorOtomatis()
    {
        $tahun = now()->format('Y');
        $last = SuratKeputusan::whereYear('created_at', $tahun)
            ->where('nomor', 'like', "%/KEP/PKK/{$tahun}")
            ->max('nomor');

        if (!$last) {
            return "001/KEP/PKK/{$tahun}";
        }

        preg_match('/(\d+)\/KEP\/PKK\/' . $tahun . '/', $last, $matches);
        $next = str_pad(($matches[1] ?? 0) + 1, 3, '0', STR_PAD_LEFT);
        return "{$next}/KEP/PKK/{$tahun}";
    }
    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}