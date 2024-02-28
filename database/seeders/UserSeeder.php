<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'nhatnguyen061003@gmail.com',
            'password' => Hash::make('admin@123'),
            'email_verified_at' => '2024-02-05 23:58:28',
            'remember_token' => '12345',
        ]);
    }
}
