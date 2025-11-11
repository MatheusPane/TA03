<?php
// database/migrations/2025_11_10_XXXXXX_create_surat_kuasas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_kuasas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->foreignId('pemberi_kuasa_id')->constrained('data_warga')->nullOnDelete();
            $table->foreignId('penerima_kuasa_id')->constrained('data_warga')->nullOnDelete();
            $table->text('untuk');
            $table->foreignId('dikeluarkan_di')->constrained('dusun')->nullOnDelete();
            $table->date('tanggal');
            $table->string('nama_penanda_tangan');
            $table->foreignId('jabatan_id')->constrained('ref_jabatan')->nullOnDelete();
            $table->json('tembusan')->nullable(); // array

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_kuasas');
    }
};