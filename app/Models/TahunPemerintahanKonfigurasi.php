<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TahunPemerintahanKonfigurasi extends Model
{
    use HasFactory;

    protected $table = 'tahun_pemerintahan_konfigurasi';

    protected $fillable = [
        'tahun',
        'nama',
        'active',
        'created_by',
        'updated_by',
    ];

    // relasi ke user pembuat
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relasi ke user pengubah
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
