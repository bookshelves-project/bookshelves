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
        $superAdmin = User::query()->where('email', Bookshelves::superAdminEmail())->first();
        if (! $superAdmin) {
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => Bookshelves::superAdminEmail(),
                'password' => Hash::make(Bookshelves::superAdminPassword()),
                'email_verified_at' => now(),
                'role' => UserRoleEnum::super_admin,
                'is_blocked' => false,
            ]);
        }
    }
}
