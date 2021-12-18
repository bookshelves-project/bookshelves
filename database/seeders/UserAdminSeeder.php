<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (! Role::exists()) {
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        }

        $users = [
            [
                'name' => config('app.name').' Admin',
                'email' => config('bookshelves.admin.email'),
                'password' => Hash::make(config('bookshelves.admin.password')),
            ],
        ];
        foreach ($users as $key => $userRaw) {
            $user = User::create([
                'name' => $userRaw['name'],
                'email' => $userRaw['email'],
                'email_verified_at' => new DateTime(),
                'password' => $userRaw['password'],
                'about' => 'Super admin of plateform',
                'gender' => GenderEnum::unknown(),
                'use_gravatar' => false,
                'display_comments' => true,
                'display_favorites' => true,
                'display_gender' => true,
            ]);
            $user->roles()->attach(Role::whereName(RoleEnum::user())->first());
            $user->roles()->attach(Role::whereName(RoleEnum::admin())->first());
            $user->save();
        }
    }
}
