<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dusun', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('tahun_konfigurasi_id')->nullable()
                  ->constrained('tahun_pemerintahan_konfigurasi')->nullOnDelete();

            // audit & control
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true); // ✅ ganti ke boolean

            // kalau maksudnya unik per nama + tahun, tambahin nama
            $table->unique(['nama', 'tahun_konfigurasi_id'], 'dusun_nama_tahun_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dusun');
    }
};
