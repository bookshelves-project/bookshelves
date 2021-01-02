<?php

namespace Database\Seeders;

use Hash;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'     => 'Ewilan',
                'email'    => 'ewilan@dotslashplay.it',
                'password' => Hash::make('password'),
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

        Team::create([
            'user_id'       => 1,
            'name'          => 'Administrator',
            'personal_team' => false,
        ]);

        Team::create([
            'user_id'       => 1,
            'name'          => "Ewilan's Team",
            'personal_team' => true,
        ]);

        Team::create([
            'user_id'       => 2,
            'name'          => "Edward's Team",
            'personal_team' => true,
        ]);

        $usersCreated = User::all();

        foreach ($usersCreated as $key => $user) {
            $user->current_team_id = 1;
            $user->save();
        }
    }
}
