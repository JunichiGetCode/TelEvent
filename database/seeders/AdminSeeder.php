<?php

namespace Database\Seeders; // Pastikan ini sudah benar

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@login.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('adminpassword'),
                'role' => 'admin',
            ]
        );
    }
}
