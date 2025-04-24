<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'tak@gmail.com',
                'type' => 1, // Admin
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Regular User',
                'email' => 'regular@gmail.com',
                'type' => 0, // User
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
