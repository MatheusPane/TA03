<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanWarga extends Model
{
    protected $table = 'kegiatan_warga';
    protected $fillable = ['warga_id', 'ref_kegiatan_id', 'ikut', 'keterangan', 'created_by', 'updated_by'];

    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

    public function refKegiatan()
    {
        return $this->belongsTo(RefKegiatanWarga::class, 'ref_kegiatan_id');
    }
    public function detail()
    {
        return $this->hasMany(
            KegiatanWargaDetail::class,
            'kegiatan_warga_id'
        );
    }
    public function jenisKader()
    {
        return $this->belongsToMany(
            RefJenisKader::class,
            'kegiatan_warga_detail',
            'kegiatan_warga_id',
            'ref_jenis_kader_id'
        );
    }
}