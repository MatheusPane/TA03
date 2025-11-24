<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            // Tambah foreign key ke ref_kebutuhan_khusus
            $table->foreignId('kebutuhan_khusus_id')
                  ->nullable()
                  ->after('pekerjaan_id') // sesuaikan posisi jika perlu
                  ->constrained('ref_kebutuhan_khusus')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            $table->dropForeign(['kebutuhan_khusus_id']);
            $table->dropColumn('kebutuhan_khusus_id');
        });
    }
};