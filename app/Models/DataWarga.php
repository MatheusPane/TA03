<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWarga extends Model
{
    use HasFactory;

    protected $table = 'data_warga';

    protected $fillable = [
        'no_registrasi',
        'no_ktp',
        'nama',
        'jabatan_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'status_perkawinan_id',
        'agama_id',
        'pendidikan_id',
        'pekerjaan_id',
        'kebutuhan_khusus_id',          // <<< BARU
        'ikut_paud',
        'ikut_kelompok_belajar',
        'jenis_kelompok_belajar_id',
        'ikut_akseptor_kb',
        'jenis_akseptor_kb_id',
        'ikut_koperasi',
        'jenis_koperasi_id',
        'memiliki_tabungan',
        'created_by',
        'updated_by',
        'active',
    ];

    // =========================
    // RELASI KE REFERENSI
    // =========================

    public function jabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'jabatan_id');
    }

    public function statusPerkawinan()
    {
        return $this->belongsTo(RefStatusPerkawinan::class, 'status_perkawinan_id');
    }

    public function agama()
    {
        return $this->belongsTo(RefAgama::class, 'agama_id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(RefPendidikan::class, 'pendidikan_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(RefPekerjaan::class, 'pekerjaan_id');
    }

    // <<< BARU: Relasi Kebutuhan Khusus >>>
    public function kebutuhanKhusus()
    {
        return $this->belongsTo(RefKebutuhanKhusus::class, 'kebutuhan_khusus_id');
    }

    public function jenisKoperasi()
    {
        return $this->belongsTo(RefJenisKoperasi::class, 'jenis_koperasi_id');
    }

    public function jenisAkseptorKb()
    {
        return $this->belongsTo(RefJenisAkseptorKb::class, 'jenis_akseptor_kb_id');
    }

    public function jenisKelompokBelajar()
    {
        return $this->belongsTo(RefJenisKelompokBelajar::class, 'jenis_kelompok_belajar_id');
    }

    // Relasi lain tetap
    public function dasawismaAnggota()
    {
        return $this->hasOne(DasawismaAnggota::class, 'warga_id');
    }

    public function kegiatanWarga()
    {
        return $this->hasMany(KegiatanWarga::class, 'warga_id');
    }

    // Helper PUS & WUS tetap sama
    public function isPus(): bool
    {
        if (!$this->umur || !$this->status_perkawinan_id) return false;
        $isMarried = in_array($this->statusPerkawinan?->id, [2]); // asumsi 2 = Kawin
        $isFertileAge = $this->umur >= 15 && $this->umur <= 49;
        return $isMarried && $isFertileAge;
    }

    public function isWus(): bool
    {
        if ($this->jenis_kelamin !== 'P' || !$this->umur) return false;
        return $this->umur >= 15 && $this->umur <= 49;
    }

    // Relasi audit
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Optional: accessor biar di view tinggal panggil $warga->kebutuhan_khusus_nama
    public function getKebutuhanKhususNamaAttribute()
    {
        return $this->kebutuhanKhusus?->nama ?? '-';
    }   
    public function kader()
    {
        return $this->hasMany(Kader::class, 'warga_id');
    }
    public function keluargaAnggota()
        {
            return $this->hasOne(DataKeluargaAnggota::class, 'warga_id');
        }

        public function keluarga()
        {
            return $this->hasOneThrough(
                DataKeluarga::class,
                DataKeluargaAnggota::class,
                'warga_id',
                'id',
                'id',
                'keluarga_id'
            );
        }

        public function dusun()
        {
            return $this->keluarga?->dusun();
        }

}