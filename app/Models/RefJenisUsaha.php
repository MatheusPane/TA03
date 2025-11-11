<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisUsaha extends Model
{
    use HasFactory;

    protected $table = 'ref_jenis_usaha';

    protected $fillable = ['nama'];

    public function keluargaDetails()
    {
        return $this->hasMany(DataKeluargaDetail::class, 'jenis_usaha_id');
    }
}