<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()->superAdmin()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com',
        ]);
        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);
        User::factory(10)->admin()->create();
    }
}
