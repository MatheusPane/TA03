<?php
// database/migrations/2025_11_10_XXXXXX_create_surat_edarans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_edarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('tentang');
            $table->text('poin_1');
            $table->text('poin_2');
            $table->text('poin_3');
            $table->text('poin_4');
            $table->foreignId('dikeluarkan_di')->constrained('dusun')->nullOnDelete();
            $table->date('tanggal');
            $table->string('nama_penanda_tangan');
            $table->foreignId('jabatan_id')->constrained('ref_jabatan')->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['created_by', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_edarans');
    }
};