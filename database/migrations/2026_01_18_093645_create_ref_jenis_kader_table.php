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
        Schema::create('ref_jenis_kader', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_kegiatan_warga_id')
                  ->constrained('ref_kegiatan_warga')
                  ->cascadeOnDelete();
        
            $table->string('nama'); // PKBN, PKDRT, Pola Asuh, Lansia
            $table->boolean('active')->default(true);
        
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_jenis_kader');
    }
};
