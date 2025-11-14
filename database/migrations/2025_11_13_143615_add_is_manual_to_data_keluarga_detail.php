<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('data_keluarga_detail', function (Blueprint $table) {
        $table->boolean('is_manual')->default(false)->after('kesehatan_lingkungan');
    });
}

public function down()
{
    Schema::table('data_keluarga_detail', function (Blueprint $table) {
        $table->dropColumn('is_manual');
    });
}
};
