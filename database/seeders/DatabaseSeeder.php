<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sentaprint.com'],
            [
                'phone' => '081234567890',
                'name' => 'Admin Senta Print',
                'password' => bcrypt('password'),
            ]
        );
    }
}
