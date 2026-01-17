<?php

namespace App\Http\Controllers;

use App\Models\BukuInventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuInventarisController extends Controller
{
    /**
     * Menampilkan daftar inventaris
     */
    public function index()
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        $inventaris = BukuInventaris::latest()->get();
        return view('buku_inventaris.index', compact('inventaris'));
    }

    /**
     * Menampilkan form tambah barang
     */
    public function create()
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        return view('buku_inventaris.create');
    }

    /**
     * Menyimpan data barang baru
     */
    public function store(Request $request)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        $validated = $request->validate([
            'nama_barang'       => 'required|string|max:255',
            'asal_barang'       => 'required|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'jumlah'            => 'required|integer|min:1',
            'tempat_penyimpanan'=> 'required|string|max:100',
            'kondisi_barang'    => 'required|in:Baik,Cukup Baik,Rusak Ringan,Rusak Berat,Hilang',
            'keterangan'        => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        BukuInventaris::create($validated);

        return redirect()->route('buku-inventaris.index')
            ->with('success', 'Barang berhasil ditambahkan ke inventaris.');
    }

    /**
     * Menampilkan form edit barang
     */
    public function edit($id)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        $barang = BukuInventaris::findOrFail($id);
        return view('buku_inventaris.edit', compact('barang'));
    }

    /**
     * Memperbarui data barang
     */
    public function update(Request $request, $id)
    {
        $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

        $barang = BukuInventaris::findOrFail($id);

        $validated = $request->validate([
            'nama_barang'       => 'required|string|max:255',
            'asal_barang'       => 'required|string|max:255',
            'tanggal_pembelian' => 'nullable|date',
            'jumlah'            => 'required|integer|min:1',
            'tempat_penyimpanan'=> 'required|string|max:100',
            'kondisi_barang'    => 'required|in:Baik,Cukup Baik,Rusak Ringan,Rusak Berat,Hilang',
            'keterangan'        => 'nullable|string',
        ]);

        $validated['updated_by'] = Auth::id();
        $barang->update($validated);

        return redirect()->route('buku-inventaris.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    /**
     * Menghapus barang dari inventaris
     */
    public function destroy($id)
    {
        $this->authorizeRole(['Admin', 'Pengurus']); // Hanya Admin & Pengurus yang boleh hapus

        $barang = BukuInventaris::findOrFail($id);
        $barang->delete();

        return redirect()->route('buku-inventaris.index')
            ->with('success', 'Barang berhasil dihapus dari inventaris.');
    }
    public function show($id)
{
    $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

    $barang = BukuInventaris::findOrFail($id);
    return view('buku_inventaris.show', compact('barang'));
}
public function printIndex()
{
    $this->authorizeRole(['Admin', 'Kader', 'Pengurus']);

    $inventaris = BukuInventaris::latest()->get();
    return view('buku_inventaris.print-index', compact('inventaris'));
}
    /**
     * Method pembantu untuk authorize role
     * (sama seperti yang kamu pakai di controller lain)
     */
    private function authorizeRole(array $roles)
    {
        if (!Auth::user()?->hasRole($roles)) {
            abort(403, 'Akses ditolak.');
        }
    }
}