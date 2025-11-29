<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illauthinate\Support\Facades\Auth;
use App\Models\User;
use App\UsersType;
use App\UsersStatus;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create default admin user
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => UsersType::SuperAdmin,
            'status' => UsersStatus::Active,
        ]);
    }
}

