<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanWargaDetail extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_warga_detail';

    protected $fillable = [
        'kegiatan_warga_id',
        'ref_jenis_kader_id',
        'aktif'
    ];

    /* ================= RELATION ================= */

    // ke kegiatan besar
    public function kegiatanWarga()
    {
        return $this->belongsTo(
            KegiatanWarga::class,
            'kegiatan_warga_id'
        );
    }

    // ke jenis kader / sub kegiatan
    public function jenisKader()
    {
        return $this->belongsTo(
            RefJenisKader::class,
            'ref_jenis_kader_id'
        );
    }
}
