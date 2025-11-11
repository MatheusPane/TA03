<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefKegiatanWarga extends Model
{
    use HasFactory;

    protected $table = 'ref_kegiatan_warga';

    protected $fillable = [
        'nama',
        'created_by',
        'updated_by',
        'active',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function kegiatanWarga()
    {
        return $this->hasMany(KegiatanWarga::class, 'ref_kegiatan_id');
    }
}
