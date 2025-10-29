<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DasawismaAnggota extends Model
{
    use HasFactory;

    protected $table = 'dasawisma_anggota';

    protected $fillable = [
        'dasawisma_id',
        'warga_id',
        'peran',
        'created_by',
        'updated_by',
        'active',
    ];

    public function dasawisma()
    {
        return $this->belongsTo(Dasawisma::class, 'dasawisma_id');
    }

    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
