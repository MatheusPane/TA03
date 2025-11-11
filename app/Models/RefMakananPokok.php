<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefMakananPokok extends Model
{
    use HasFactory;

    protected $table = 'ref_makanan_pokok';

    protected $fillable = ['nama'];

    public function keluargaDetails()
    {
        return $this->hasMany(DataKeluargaDetail::class, 'makanan_pokok_lain_id');
    }
}