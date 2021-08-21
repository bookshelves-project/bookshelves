<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        User::truncate();
        DB::statement('SET foreign_key_checks=1');

        if (! Role::exists()) {
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        }

        $users = [
            [
                'name'     => 'Admin',
                'email'    => config('bookshelves.admin.email'),
                'password' => Hash::make(config('bookshelves.admin.password')),
            ],
        ];
        foreach ($users as $key => $userRaw) {
            $user = User::create([
                'name'              => $userRaw['name'],
                'email'             => $userRaw['email'],
                'email_verified_at' => new DateTime(),
                'password'          => $userRaw['password'],
            ]);
            $user->roles()->attach(Role::whereName(RoleEnum::USER())->first());
            $user->roles()->attach(Role::whereName(RoleEnum::ADMIN())->first());
            $user->save();
        }
    }
}