<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefStatusPerkawinanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ref_status_perkawinan')->insertOrIgnore([
            ['nama' => 'Belum Kawin', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kawin', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cerai Hidup', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Cerai Mati', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
