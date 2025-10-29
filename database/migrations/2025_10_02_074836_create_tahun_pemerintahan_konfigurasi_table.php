<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tahun_pemerintahan_konfigurasi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun')->index();
            $table->string('nama')->nullable();

            // audit & control
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true); // ✅ ganti ke boolean
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahun_pemerintahan_konfigurasi');
    }
};
