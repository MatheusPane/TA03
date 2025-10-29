<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1️⃣ Buat role Admin
            $adminRole = Role::firstOrCreate([
                'nama' => 'Admin',
            ], [
                'active' => true,
            ]);

            // 2️⃣ Buat user admin
            $adminUser = User::firstOrCreate([
                'email' => 'admin@example.com',
            ], [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // ubah nanti
                'active' => true,
            ]);

            // 3️⃣ Hubungkan user dan role
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        });
    }
}
