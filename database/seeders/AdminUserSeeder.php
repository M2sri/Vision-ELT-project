<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@vision249.com',
            ],
            [
                'name'     => 'Admin',
                'password' => Hash::make('Admin'),
            ]
        );
    }
}
