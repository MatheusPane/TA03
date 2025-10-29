<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaKonfigurasi extends Model
{
    use HasFactory;

    protected $table = 'desa_konfigurasi';

    protected $fillable = [
        'key',
        'value',
        'created_by',
        'updated_by',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relasi ke user yang membuat konfigurasi.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke user yang terakhir mengupdate konfigurasi.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
