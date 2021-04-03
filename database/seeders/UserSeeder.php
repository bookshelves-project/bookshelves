<?php

namespace Database\Seeders;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
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

        $users = [
            [
                'name'     => 'Ewilan',
                'email'    => config('bookshelves.admin.email'),
                'password' => Hash::make(config('bookshelves.admin.password')),
            ],
            [
                'name'     => 'Edward',
                'email'    => 'edward@dotslashplay.it',
                'password' => Hash::make('password'),
            ],
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }

        $admin = User::whereEmail('ewilan@dotslashplay.it')->first();
        Role::create([
            'name' => 'admin',
        ]);
        $admin->assignRole('admin');
    }
}
