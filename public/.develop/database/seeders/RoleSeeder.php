<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // DB::statement('SET foreign_key_checks=0');
        // Role::truncate();
        // DB::statement('SET foreign_key_checks=1');

        // /** @var UserRole[] $roles */
        // $roles = [
        //     [
        //         'name' => UserRole::admin,
        //     ],
        //     [
        //         'name' => UserRole::publisher,
        //     ],
        //     [
        //         'name' => UserRole::user,
        //     ],
        // ];

        // /** @var UserRole $role */
        // foreach ($roles as $key => $role) {
        //     Role::firstOrCreate($role);
        // }
    }
}
