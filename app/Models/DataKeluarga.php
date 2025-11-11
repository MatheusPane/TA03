<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKeluarga extends Model
{
    use HasFactory;

    protected $table = 'data_keluarga';

    protected $fillable = [
        'no_kk',
        'dusun_id',
        'dasawisma_id', // Sudah ada
        'created_by',
        'updated_by',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // === RELASI ===
    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dusun_id');
    }

    public function dasawisma()
    {
        return $this->belongsTo(Dasawisma::class, 'dasawisma_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(DataKeluargaAnggota::class, 'keluarga_id');
    }

    public function detail()
    {
        return $this->hasOne(DataKeluargaDetail::class, 'keluarga_id');
    }

    public function kepalaKeluargaAnggota()
    {
        return $this->hasOne(DataKeluargaAnggota::class, 'keluarga_id')
            ->whereHas('statusDalamKeluarga', function ($q) {
                $q->where('nama', 'like', '%kepala%'); // atau gunakan kode
            });
    }
// Akses warga kepala keluarga
    public function kepalaKeluarga()
    {
        return $this->kepalaKeluargaAnggota()->with('warga');
    }
}