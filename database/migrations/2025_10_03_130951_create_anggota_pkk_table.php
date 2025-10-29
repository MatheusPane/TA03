<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('anggota_pkk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('data_warga')->cascadeOnDelete();
            $table->string('jabatan')->nullable(); // contoh: Ketua, Sekretaris, Bendahara, Anggota

            // audit & control
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true);

            $table->unique('warga_id', 'unique_anggota_pkk');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_pkk');
    }
};
