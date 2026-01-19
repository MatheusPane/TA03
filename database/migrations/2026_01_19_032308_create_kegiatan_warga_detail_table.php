<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_warga_detail', function (Blueprint $table) {
            $table->id();

            // relasi ke kegiatan_warga (kegiatan besar)
            $table->foreignId('kegiatan_warga_id')
                  ->constrained('kegiatan_warga')
                  ->cascadeOnDelete();

            // sub kegiatan / jenis kader
            $table->foreignId('ref_jenis_kader_id')
                  ->constrained('ref_jenis_kader')
                  ->cascadeOnDelete();

            $table->boolean('aktif')->default(true);
            $table->timestamps();

            // cegah duplikasi
            $table->unique([
                'kegiatan_warga_id',
                'ref_jenis_kader_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_warga_detail');
    }
};
