<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mbg.id'],
            [
                'name'     => 'Admin MBG',
                'username' => 'admin',
                'email'    => 'admin@mbg.id',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'superadmin@mbg.id'],
            [
                'name'     => 'Super Admin MBG',
                'username' => 'superadmin',
                'email'    => 'superadmin@mbg.id',
                'password' => Hash::make('superpassword123'),
                'role'     => 'superadmin',
            ]
        );
    }
}
