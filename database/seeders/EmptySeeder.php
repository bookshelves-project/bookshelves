<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Kiwilan\Steward\Enums\UserRoleEnum;

class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => config('bookshelves.super_admin.email'),
            'password' => Hash::make(config('bookshelves.super_admin.password')),
            'role' => UserRoleEnum::super_admin,
        ]);
    }
}
