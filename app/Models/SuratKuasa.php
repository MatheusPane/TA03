<?php
// app/Models/SuratKuasa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKuasa extends Model
{
    use SoftDeletes;

    protected $table = 'surat_kuasas';

    protected $fillable = [
        'nomor', 'pemberi_kuasa_id', 'penerima_kuasa_id', 'untuk',
        'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id',
        'tembusan', 'created_by', 'updated_by', 'active'
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'tembusan' => 'array',
        'active' => 'boolean',
    ];

    // RELASI → HAPUS ->with('dusun')!
    public function pemberiKuasa()
    {
        return $this->belongsTo(DataWarga::class, 'pemberi_kuasa_id');
    }

    public function penerimaKuasa()
    {
        return $this->belongsTo(DataWarga::class, 'penerima_kuasa_id');
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dikeluarkan_di');
    }

    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}