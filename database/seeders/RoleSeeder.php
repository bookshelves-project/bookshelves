<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        Role::truncate();
        DB::statement('SET foreign_key_checks=1');

        /** @var RoleEnum[] $roles */
        $roles = [
            [
                'name' => RoleEnum::ADMIN(),
            ],
            [
                'name' => RoleEnum::PUBLISHER(),
            ],
            [
                'name' => RoleEnum::USER(),
            ],
        ];

        /** @var RoleEnum $role */
        foreach ($roles as $key => $role) {
            Role::firstOrCreate($role);
        }
    }
}
