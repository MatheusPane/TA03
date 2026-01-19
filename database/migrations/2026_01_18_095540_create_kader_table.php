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
        Schema::create('kader', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('warga_id')
                  ->constrained('data_warga')
                  ->cascadeOnDelete();
        
            $table->foreignId('ref_jenis_kader_id')
                  ->constrained('ref_jenis_kader')
                  ->cascadeOnDelete();
        
            $table->foreignId('dusun_id')
                  ->constrained('dusun')
                  ->cascadeOnDelete();
            
        
            $table->year('tahun');
        
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        
            // satu warga tidak boleh double kader di jenis yang sama
            $table->unique(['warga_id', 'ref_jenis_kader_id', 'tahun']);
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kader');
    }
};
