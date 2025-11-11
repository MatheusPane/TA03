<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat_keputusans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique(); // UNIK!
            $table->string('tentang');
            $table->text('menimbang')->nullable();
            $table->json('mengingat'); // [poin1, poin2, ...]
            $table->text('memperhatikan')->nullable();
            $table->json('menetapkan'); // ["PERTAMA" => "...", "KEDUA" => "..."]
            $table->string('ditetapkan_di');
            $table->date('tanggal');
            $table->string('nama_penanda_tangan');
            $table->string('jabatan_penanda_tangan');
            $table->json('tembusan'); // ["Yth. Bupati", ...]
            
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
                  
            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->boolean('active')->default(true);
            $table->softDeletes(); // BISA DI-RESTORE!
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index('created_by');
            $table->index('tanggal');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keputusans');
    }
};