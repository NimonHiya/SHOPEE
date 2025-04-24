<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'tes1',
                'email' => 'tes@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'tes',
                'email' => 'tes2@gmail.com',
                'password' => Hash::make('admin123'),
                'type' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
