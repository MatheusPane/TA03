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
        'dasawisma_id', // Tambahan
        'created_by',
        'updated_by',
        'active',
    ];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dusun_id');
    }

    public function dasawisma() // Tambahan
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
}