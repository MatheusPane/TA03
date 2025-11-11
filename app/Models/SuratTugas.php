<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratTugas extends Model
{
    use SoftDeletes;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'nomor', 'penerima_tugas_id', 'untuk', 'hari_tanggal', 'waktu', 'tempat',
        'dikeluarkan_di', 'tanggal', 'nama_penanda_tangan', 'jabatan_id',
        'dasar', 'tembusan', 'created_by', 'updated_by', 'active'
    ];

    // WAJIB INI!
    protected $casts = [
        'dasar' => 'array',
        'tembusan' => 'array',
        'tanggal' => 'date',
        'active' => 'boolean',
    ];

    // Relasi
    public function penerimaTugas()
    {
        return $this->belongsTo(DataWarga::class, 'penerima_tugas_id');
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dikeluarkan_di');
    }

    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'jabatan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}