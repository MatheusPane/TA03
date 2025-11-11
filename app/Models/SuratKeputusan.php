<?php
// app/Models/SuratKeputusan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeputusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_keputusans';

    protected $fillable = [
        'nomor',
        'tentang',
        'menimbang',
        'mengingat',
        'memperhatikan',
        'menetapkan',
        'ditetapkan_di',
        'tanggal',
        'nama_penanda_tangan',
        'jabatan_id',
        'tembusan',
        'created_by',
        'updated_by',
        'active'
    ];

    protected $casts = [
        'mengingat' => 'array',
        'menetapkan' => 'array',
        'tembusan' => 'array',
        'tanggal' => 'date:d F Y',
        'active' => 'boolean',
        'created_at' => 'datetime:d F Y H:i',
        'updated_at' => 'datetime:d F Y H:i',
        'deleted_at' => 'datetime:d F Y H:i',
        'jabatan_id' => 'integer',
    ];

    // Relasi: Dibuat oleh
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi: Diupdate oleh
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scope: Hanya yang aktif
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Accessor: Nomor lengkap untuk PDF
    public function getNomorLengkapAttribute()
    {
        return "{$this->nomor}/KEP/PKK/{$this->tanggal->format('Y')}";
    }

    // Mutator: Otomatis isi updated_by
    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }
    public function jabatan()
    {
        return $this->belongsTo(\App\Models\RefJabatan::class, 'jabatan_id');
    }

    // ACCESSOR: Tampilkan nama jabatan
    public function getJabatanPenandaTanganAttribute()
    {
        return $this->jabatan?->nama ?? 'Jabatan Tidak Diketahui';
    }
}