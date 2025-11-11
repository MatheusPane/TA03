<?php
// app/Models/SuratBiasa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratBiasa extends Model
{
    use SoftDeletes;

    protected $table = 'surat_biasas';

    protected $fillable = [
        'nomor', 'lampiran', 'perihal', 'kepada', 'di',
        'tanggal',
        'kata_pembuka', 'isi_surat', 'penutup',
        'nama_penanda_tangan', 'jabatan_id', 'tembusan',
        'created_by', 'updated_by', 'active'
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',  // CAST JADI DATE!
        'tembusan' => 'array',
        'active' => 'boolean',
    ];

    // Relasi
    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}