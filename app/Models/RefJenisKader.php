<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJenisKader extends Model
{
    protected $table = 'ref_jenis_kader';

    protected $fillable = [
        'nama',
        'ref_kegiatan_warga_id',
        'created_by',
        'updated_by',
        'active'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(RefKegiatanWarga::class, 'ref_kegiatan_warga_id');
    }

    public function kader()
    {
        return $this->hasMany(Kader::class);
    }
    public function kegiatanWargaDetail()
    {
        return $this->hasMany(
            KegiatanWargaDetail::class,
            'ref_jenis_kader_id'
        );
    }
}
