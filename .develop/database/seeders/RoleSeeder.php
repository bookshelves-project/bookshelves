<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
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

        // /** @var RoleEnum[] $roles */
        // $roles = [
        //     [
        //         'name' => RoleEnum::admin,
        //     ],
        //     [
        //         'name' => RoleEnum::publisher,
        //     ],
        //     [
        //         'name' => RoleEnum::user,
        //     ],
        // ];

        // /** @var RoleEnum $role */
        // foreach ($roles as $key => $role) {
        //     Role::firstOrCreate($role);
        // }
    }
}
