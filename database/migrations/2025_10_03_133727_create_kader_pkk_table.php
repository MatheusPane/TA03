<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kader_pkk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_pkk_id')->constrained('anggota_pkk')->cascadeOnDelete();
            $table->string('no_registrasi_tp_pkk')->unique();
            $table->enum('kedudukan_fungsi', [
                'dalam keanggotaan tp pkk',
                'kader umum',
                'kader khusus'
            ]);

            // audit & control
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kader_pkk');
    }
};
