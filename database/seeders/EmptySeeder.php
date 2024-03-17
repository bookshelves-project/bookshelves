<?php

namespace Database\Seeders;

use App\Facades\Bookshelves;
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
            'email' => Bookshelves::superAdminEmail(),
            'password' => Hash::make(Bookshelves::superAdminPassword()),
            'role' => UserRoleEnum::super_admin,
            'is_blocked' => false,
        ]);
    }
}
