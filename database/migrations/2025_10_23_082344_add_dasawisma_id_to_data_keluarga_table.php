<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_keluarga', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada
            if (!Schema::hasColumn('data_keluarga', 'dasawisma_id')) {
                $table->foreignId('dasawisma_id')
                      ->nullable()
                      ->after('dusun_id')
                      ->constrained('dasawisma')
                      ->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('data_keluarga', function (Blueprint $table) {
            if (Schema::hasColumn('data_keluarga', 'dasawisma_id')) {
                $table->dropForeign(['dasawisma_id']);
                $table->dropColumn('dasawisma_id');
            }
        });
    }
};