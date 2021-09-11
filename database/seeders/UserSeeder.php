<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'password' => bcrypt(12345678)
        ]);
        User::query()->create([
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => bcrypt(12345678)
        ]);
    }
}