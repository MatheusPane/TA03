<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_keluarga_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->unique()->constrained('data_keluarga')->cascadeOnDelete();
        
            // === STATISTIK ANGGOTA ===
            $table->integer('jumlah_anggota')->default(0);
            $table->integer('laki_laki')->default(0);
            $table->integer('perempuan')->default(0);
        
            // === FASILITAS & KRITERIA ===
            $table->enum('makanan_pokok', ['Beras', 'Non Beras']);
            $table->foreignId('makanan_pokok_lain_id')->nullable()->constrained('ref_makanan_pokok');
        
            $table->boolean('punya_jamban')->default(false);
            $table->integer('jumlah_jamban')->default(0);
        
            $table->foreignId('sumber_air_id')->nullable()->constrained('ref_sumber_air');
            $table->boolean('punya_tempat_sampah')->default(false);
            $table->boolean('punya_saluran_limbah')->default(false);
            $table->boolean('stiker_p4k')->default(false);
        
            $table->enum('kriteria_rumah', ['Sehat', 'Kurang Sehat']);
        
            // === USAHA & LINGKUNGAN ===
            $table->boolean('up2k')->default(false);
            $table->foreignId('jenis_usaha_id')->nullable()->constrained('ref_jenis_usaha');
        
            $table->boolean('kesehatan_lingkungan')->default(false);
        
            // === AUDIT ===
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_keluarga_detail');
    }
};
