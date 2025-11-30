<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataKeluargaDetail;
use App\Models\RefMakananPokok;
use App\Models\RefSumberAir;
use App\Models\RefJenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluargaDetailController extends Controller
{
    public function edit($keluarga_id)
{
    $this->authorizeRole(['Admin', 'Kader']);

    $keluarga = DataKeluarga::findOrFail($keluarga_id);

    $detail = $keluarga->detail ?? $keluarga->detail()->create([
        'keluarga_id' => $keluarga_id,
        'makanan_pokok' => 'Beras',
        'kriteria_rumah' => 'Kurang Sehat',
        'jumlah_kk' => 1,
        'balita' => 0,           // total
        'pus' => 0,
        'wus' => 0,
        'buta' => 0,
        'ibu_hamil' => 0,
        'ibu_menyusui' => 0,
        'lansia' => 0,
        'punya_jamban' => false,
        'jumlah_jamban' => 0,
        'sumber_air_id' => null,
        'punya_tempat_sampah' => false,
        'punya_saluran_limbah' => false,
        'stiker_p4k' => false,
        'up2k' => false,
        'jenis_usaha_id' => null,
        'kesehatan_lingkungan' => false,
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);

    // Kirim data terpisah ke view (hanya untuk tampilan)
    $detail->balita_laki = 0;
    $detail->balita_perempuan = 0;

    // Kalau sudah ada data, hitung proporsional atau biarkan default (bisa juga simpan di session/cookie kalau mau lebih akurat)
    // Untuk simpel, kita anggap 0 dulu, atau bisa diisi manual

    return view('data_keluarga.detail.edit', compact('keluarga', 'detail'));
}

public function update(Request $request, $keluarga_id)
{
    $this->authorizeRole(['Admin', 'Kader']);

    $validated = $request->validate([
        'makanan_pokok' => 'required|in:Beras,Non Beras',
        'makanan_pokok_lain_id' => 'nullable|exists:ref_makanan_pokok,id|required_if:makanan_pokok,Non Beras',
        'punya_jamban' => 'required|in:0,1',
        'jumlah_jamban' => 'nullable|integer|min:1|required_if:punya_jamban,1',
        'sumber_air_id' => 'nullable|exists:ref_sumber_air,id',
        'punya_tempat_sampah' => 'required|in:0,1',
        'punya_saluran_limbah' => 'required|in:0,1',
        'stiker_p4k' => 'required|in:0,1',
        'kriteria_rumah' => 'required|in:Sehat,Kurang Sehat',
        'up2k' => 'required|in:0,1',
        'jenis_usaha_id' => 'nullable|exists:ref_jenis_usaha,id|required_if:up2k,1',
        'kesehatan_lingkungan' => 'required|in:0,1',

        'jumlah_kk' => 'required|integer|min:0',
        
        // INI YANG BARU: pisah input, tapi hanya untuk UI
        'balita_laki'      => 'required|integer|min:0',
        'balita_perempuan' => 'required|integer|min:0',

        'pus' => 'required|integer|min:0',
        'wus' => 'required|integer|min:0',
        'buta' => 'required|integer|min:0',
        'ibu_hamil' => 'required|integer|min:0',
        'ibu_menyusui' => 'required|integer|min:0',
        'lansia' => 'required|integer|min:0',
    ]);

    $keluarga = DataKeluarga::findOrFail($keluarga_id);
    $detail = $keluarga->detail ?? $keluarga->detail()->create(['keluarga_id' => $keluarga_id]);

    $detail->update([
        // ... field lain sama seperti sebelumnya
        'jumlah_kk'        => $request->jumlah_kk,
        'balita'           => $request->balita_laki + $request->balita_perempuan, // ← hanya ini yang disimpan
        'pus'              => $request->pus,
        'wus'              => $request->wus,
        'buta'             => $request->buta,
        'ibu_hamil'        => $request->ibu_hamil,
        'ibu_menyusui'     => $request->ibu_menyusui,
        'lansia'           => $request->lansia,

        'makanan_pokok' => $request->makanan_pokok,
        'makanan_pokok_lain_id' => $request->makanan_pokok_lain_id,
        'punya_jamban' => $request->punya_jamban,
        'jumlah_jamban' => $request->jumlah_jamban,
        'sumber_air_id' => $request->sumber_air_id,
        'punya_tempat_sampah' => $request->punya_tempat_sampah,
        'punya_saluran_limbah' => $request->punya_saluran_limbah,
        'stiker_p4k' => $request->stiker_p4k,
        'kriteria_rumah' => $request->kriteria_rumah,
        'up2k' => $request->up2k,
        'jenis_usaha_id' => $request->jenis_usaha_id,
        'kesehatan_lingkungan' => $request->kesehatan_lingkungan,

        'updated_by' => Auth::id(),
        'is_manual'  => true,
    ]);

    return redirect()
        ->route('data_keluarga.show', $keluarga_id)
        ->with('success', 'Detail keluarga berhasil diperbarui.');
}

    private function authorizeRole(array $roles)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}