<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratEdaran extends Model
{
    use SoftDeletes;

    protected $table = 'surat_edarans';

    protected $fillable = [
        'nomor', 'tentang', 'poin_1', 'poin_2', 'poin_3', 'poin_4',
        'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id',
        'created_by', 'updated_by', 'active'
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'active' => 'boolean',
    ];

    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function dusun() { return $this->belongsTo(Dusun::class, 'dikeluarkan_di'); }
    public function jabatan() { return $this->belongsTo(RefJabatan::class); }

    public function scopeActive($query) { return $query->where('active', true); }
}