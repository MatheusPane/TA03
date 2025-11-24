<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKebutuhanKhusus extends Model
{
    use HasFactory;

    protected $table = 'ref_kebutuhan_khusus';

    protected $fillable = [
        'nama',
        'created_by',
        'updated_by',
        'active',
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
