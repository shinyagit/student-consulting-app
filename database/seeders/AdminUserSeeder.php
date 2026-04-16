<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.initial_email');
        $password = config('admin.initial_password');

        if (! $email || ! $password) {
            throw new \RuntimeException('INITIAL_ADMIN_EMAIL or INITIAL_ADMIN_PASSWORD is not set.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => '管理者',
                'password' => Hash::make($password),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'name' => 'スタッフ1',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'name' => 'スタッフ2',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );
    }
}