<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('data_warga')->onDelete('cascade');
            $table->foreignId('ref_kegiatan_id')->constrained('ref_kegiatan_warga')->onDelete('cascade');
            $table->boolean('ikut')->default(true); // Y/T
            $table->text('keterangan')->nullable(); // Jenis kegiatan yang diikuti
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Unik: satu warga hanya boleh punya 1 entri per jenis kegiatan
            $table->unique(['warga_id', 'ref_kegiatan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_warga');
    }
};