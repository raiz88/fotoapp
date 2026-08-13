<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'owner@fotoapp.test'],
            [
                'name' => 'Syamim',
                'password' => 'password',
                'role' => User::ROLE_OWNER,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@fotoapp.test'],
            [
                'name' => 'Staf Demo',
                'password' => 'password',
                'role' => User::ROLE_STAFF,
                'is_active' => true,
            ]
        );
    }
}
