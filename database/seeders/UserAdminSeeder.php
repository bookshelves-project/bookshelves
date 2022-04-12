<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\MediaService;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::where('role', '!=', 'publisher')
            ->where('role', '!=', 'user')
            ->delete()
        ;

        // DatabaseSeeder::deleteRoles();
        // if (! Role::exists()) {
        //     Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        // }

        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        // $users = [
        //     [
        //         'name' => config('app.name').' Admin',
        //         'email' => config('bookshelves.admin.email'),
        //         'password' => Hash::make(config('bookshelves.admin.password')),
        //     ],
        // ];
        // foreach ($users as $key => $userRaw) {
        //     $user = User::create([
        //         'name' => $userRaw['name'],
        //         'email' => $userRaw['email'],
        //         'email_verified_at' => new DateTime(),
        //         'password' => $userRaw['password'],
        //         'about' => 'Super admin of plateform',
        //         'role' => RoleEnum::admin,
        //         'gender' => GenderEnum::unknown(),
        //         'use_gravatar' => false,
        //         'display_reviews' => true,
        //         'display_favorites' => true,
        //         'display_gender' => true,
        //     ]);
        //     // $userRole = Role::where('name', RoleEnum::user)->first();
        //     // $adminRole = Role::where('name', RoleEnum::admin)->first();

        //     // $user->roles()->attach($userRole);
        //     // $user->roles()->attach($adminRole);

        //     MediaService::create($user, $user->slug, 'users', 'avatar')
        //         ->setMedia(DatabaseSeeder::generateAvatar())
        //         ->setColor()
        //     ;
        //     MediaService::create($user, "{$user->slug}-banner", 'users', 'banner')
        //         ->setMedia(DatabaseSeeder::generateBanner())
        //         ->setColor()
        //     ;

        //     $user->save();
        // }
    }
}
