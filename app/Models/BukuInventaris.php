<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuInventaris extends Model
{
    use HasFactory;

    protected $table = 'buku_inventaris';

    protected $fillable = [
        'nama_barang',
        'asal_barang',
        'tanggal_pembelian',
        'jumlah',
        'tempat_penyimpanan',
        'kondisi_barang',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}