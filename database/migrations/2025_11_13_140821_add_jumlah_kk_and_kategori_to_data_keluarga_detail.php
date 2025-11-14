<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_keluarga_detail', function (Blueprint $table) {
            // Jumlah KK (biasanya 1, tapi bisa disesuaikan)
            $table->integer('jumlah_kk')->default(1)->after('perempuan');

            // Kategori khusus
            $table->integer('balita')->default(0)->after('jumlah_kk');
            $table->integer('pus')->default(0)->after('balita');
            $table->integer('wus')->default(0)->after('pus');
            $table->integer('buta')->default(0)->after('wus');
            $table->integer('ibu_hamil')->default(0)->after('buta');
            $table->integer('ibu_menyusui')->default(0)->after('ibu_hamil');
            $table->integer('lansia')->default(0)->after('ibu_menyusui');
        });
    }

    public function down(): void
    {
        Schema::table('data_keluarga_detail', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_kk',
                'balita',
                'pus',
                'wus',
                'buta',
                'ibu_hamil',
                'ibu_menyusui',
                'lansia'
            ]);
        });
    }
};