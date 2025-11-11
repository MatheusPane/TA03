<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_keputusans', function (Blueprint $table) {
            // 1. Tambah kolom baru
            $table->foreignId('jabatan_id')
                  ->nullable()
                  ->after('nama_penanda_tangan')
                  ->constrained('ref_jabatan')
                  ->nullOnDelete();

            // 2. Hapus kolom lama (string)
            $table->dropColumn('jabatan_penanda_tangan');
        });
    }

    public function down(): void
    {
        Schema::table('surat_keputusans', function (Blueprint $table) {
            // Kembalikan kolom string
            $table->string('jabatan_penanda_tangan')->after('nama_penanda_tangan');

            // Hapus foreign
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn('jabatan_id');
        });
    }
};