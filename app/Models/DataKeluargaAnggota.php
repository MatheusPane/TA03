<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKeluargaAnggota extends Model
{
    use HasFactory;

    protected $table = 'data_keluarga_anggota';

    protected $fillable = [
        'keluarga_id',
        'warga_id',
        'status_dalam_keluarga_id',
        'created_by',
        'updated_by',
        'active',
    ];

    // Relasi ke Data Keluarga
    public function keluarga()
    {
        return $this->belongsTo(DataKeluarga::class, 'keluarga_id');
    }

    // Relasi ke Data Warga
    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

    // Relasi ke Status Dalam Keluarga
    public function statusDalamKeluarga()
    {
        return $this->belongsTo(RefStatusDalamKeluarga::class, 'status_dalam_keluarga_id');
    }

    // Relasi ke user pembuat
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
