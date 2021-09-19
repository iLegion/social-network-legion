<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create([
           'title' => 'Admin'
        ]);
        Role::query()->create([
            'title' => 'User'
        ]);
    }
}
