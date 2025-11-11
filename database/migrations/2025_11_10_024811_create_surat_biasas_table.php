<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_biasas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('lampiran')->nullable();
            $table->string('perihal');
            $table->string('kepada');
            $table->string('di');
            $table->date('tanggal');
            $table->text('kata_pembuka');
            $table->text('isi_surat');
            $table->text('penutup');
            $table->string('nama_penanda_tangan');
            $table->foreignId('jabatan_id')
                  ->constrained('ref_jabatan')
                  ->nullOnDelete();
            $table->json('tembusan')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();

             // Index untuk pencarian cepat
             $table->index('created_by');
             $table->index('tanggal');
             $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_biasas');
    }
};