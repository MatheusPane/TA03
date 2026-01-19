<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kader extends Model
{
    protected $table = 'kader';

    protected $fillable = [
        'warga_id',
        'ref_jenis_kader_id',
        'dusun_id',
        'tahun',
        'created_by',
        'updated_by'
    ];

    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

    public function jenisKader()
    {
        return $this->belongsTo(RefJenisKader::class, 'ref_jenis_kader_id');
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }
}
