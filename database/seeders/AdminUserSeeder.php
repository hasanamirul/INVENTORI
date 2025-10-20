<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@dispermades.com'],
            [
                'name' => 'Admin Dispermades',
                'password' => Hash::make('admin000'),
                'role' => 'admin',
            ]
        );

        // User biasa
        User::updateOrCreate(
            ['email' => 'user@dispermades.com'],
            [
                'name' => 'User Dispermades',
                'password' => Hash::make('user000'),
                'role' => 'user',
            ]
        );
    }
}
