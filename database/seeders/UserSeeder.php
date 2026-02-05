<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'user_level' => 1, // Admin
                'image' => 'no_image.jpg',
                'status' => 1,
                'last_login' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Usuario Bodega',
                'username' => 'bodega',
                'password' => Hash::make('bodega123'),
                'user_level' => 2, // Bodega
                'image' => 'no_image.jpg',
                'status' => 1,
                'last_login' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Usuario Normal',
                'username' => 'usuario',
                'password' => Hash::make('usuario123'),
                'user_level' => 3, // Usuario
                'image' => 'no_image.jpg',
                'status' => 1,
                'last_login' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
