<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'password' => bcrypt(12345678)
        ])->roles()->attach(Role::query()->find(1));
        User::query()->create([
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => bcrypt(12345678)
        ])->roles()->attach(Role::query()->find(2));
    }
}
