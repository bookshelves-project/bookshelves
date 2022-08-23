<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => config('app.admin.email'),
            'password' => Hash::make(config('app.admin.password')),
        ]);
    }
}
