<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
