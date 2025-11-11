<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSumberAir extends Model
{
    use HasFactory;

    protected $table = 'ref_sumber_air';

    protected $fillable = ['nama'];

    public function keluargaDetails()
    {
        return $this->hasMany(DataKeluargaDetail::class, 'sumber_air_id');
    }
}