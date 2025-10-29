<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dasawisma extends Model
{
    use HasFactory;

    protected $table = 'dasawisma';
    protected $fillable = [
        'nama',
        'dusun_id',
        'ketua_warga_id',
        'keterangan',
        'created_by',
        'updated_by',
        'active',
    ];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dusun_id');
    }

    public function ketua()
    {
        return $this->belongsTo(DataWarga::class, 'ketua_warga_id');
    }
    public function anggota()
    {
    return $this->hasMany(DasawismaAnggota::class, 'dasawisma_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke user yang mengupdate
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
