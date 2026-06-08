<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'full_name' => 'Admin User',
                'email' => 'admin@painting-jhg.com',
                'password' => 'password123',
                'status' => 'active',
            ],
            [
                'username' => 'manager',
                'full_name' => 'Manager User',
                'email' => 'manager@painting-jhg.com',
                'password' => 'password123',
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }
    }
}
