<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dasawisma_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dasawisma_id')->constrained('dasawisma')->cascadeOnDelete();
            $table->foreignId('warga_id')->constrained('data_warga')->cascadeOnDelete();
            $table->enum('peran', ['anggota', 'wakil ketua', 'sekretaris', 'bendahara'])->default('anggota');

            // audit & control
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);

            // 1 warga tidak bisa dobel dalam kelompok yang sama
            $table->unique(['dasawisma_id', 'warga_id'], 'dasawisma_warga_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dasawisma_anggota');
    }
};
