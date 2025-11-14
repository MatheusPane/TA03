<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKeluargaDetail extends Model
{
    use HasFactory;

    protected $table = 'data_keluarga_detail';

    protected $fillable = [
        'keluarga_id',
        'jumlah_anggota',
        'laki_laki',
        'perempuan',
        'jumlah_kk', // TAMBAHAN
        'balita', 'pus', 'wus', 'buta', 'ibu_hamil', 'ibu_menyusui', 'lansia', // TAMBAHAN
        'makanan_pokok',
        'makanan_pokok_lain_id',
        'punya_jamban',
        'jumlah_jamban',
        'sumber_air_id',
        'punya_tempat_sampah',
        'punya_saluran_limbah',
        'stiker_p4k',
        'kriteria_rumah',
        'up2k',
        'jenis_usaha_id',
        'kesehatan_lingkungan',
        'created_by',
        'updated_by',
        'is_manual',
    ];

    protected $casts = [
        'punya_jamban' => 'boolean',
        'punya_tempat_sampah' => 'boolean',
        'punya_saluran_limbah' => 'boolean',
        'stiker_p4k' => 'boolean',
        'up2k' => 'boolean',
        'kesehatan_lingkungan' => 'boolean',
    ];

    // === RELASI ===
    public function keluarga()
    {
        return $this->belongsTo(DataKeluarga::class, 'keluarga_id');
    }

    public function makananPokokLain()
    {
        return $this->belongsTo(RefMakananPokok::class, 'makanan_pokok_lain_id');
    }

    public function sumberAir()
    {
        return $this->belongsTo(RefSumberAir::class, 'sumber_air_id');
    }

    public function jenisUsaha()
    {
        return $this->belongsTo(RefJenisUsaha::class, 'jenis_usaha_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // === BOOT: Otomatis isi created_by & updated_by ===
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->created_by = auth()->id();
    //         $model->updated_by = auth()->id();
    //     });

    //     static::updating(function ($model) {
    //         $model->updated_by = auth()->id();
    //     });
    // }
}