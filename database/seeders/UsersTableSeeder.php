<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate seeder for two users
        User::insert([
            [
                'name' => 'Agatha Williams',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('123456'),
            ], [
                'name' => 'Jane Doe',
                'email' => 'manager@gmail.com',
                'role' => 'manager',
                'password' => Hash::make('123456'),
            ]
        ]);
    }
}
