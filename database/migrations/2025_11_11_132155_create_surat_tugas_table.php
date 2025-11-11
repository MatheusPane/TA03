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
    Schema::create('surat_tugas', function (Blueprint $table) {
        $table->id();
        $table->string('nomor')->unique();
        $table->text('dasar')->nullable(); // JSON array
        $table->foreignId('penerima_tugas_id')->constrained('data_warga')->nullOnDelete();
        $table->text('untuk');
        $table->string('hari_tanggal');
        $table->string('waktu');
        $table->string('tempat');
        $table->foreignId('dikeluarkan_di')->constrained('dusun')->nullOnDelete();
        $table->date('tanggal');
        $table->string('nama_penanda_tangan');
        $table->foreignId('jabatan_id')->constrained('ref_jabatan')->nullOnDelete();
        $table->json('tembusan')->nullable();

        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        $table->boolean('active')->default(true);
        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};
