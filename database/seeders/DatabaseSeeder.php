<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new \RuntimeException(static::class.' cannot run in production.');
        }
        
        $this->call([
            AdminUserSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            GuidanceRecordSeeder::class,
        ]);
    }
}