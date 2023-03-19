<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::query()
            ->delete()
        ;
        // User::where('role', '!=', 'publisher')
        //     ->where('role', '!=', 'user')
        //     ->delete()
        // ;

        // DatabaseSeeder::deleteRoles();
        // if (! Role::exists()) {
        //     Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        // }

        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => config('app.admin.email'),
            'password' => Hash::make(config('app.admin.password')),
        ]);
        // User::factory()->admin()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        // ]);

        // $users = [
        //     [
        //         'name' => config('app.name').' Admin',
        //         'email' => config('app.admin.email'),
        //         'password' => Hash::make(config('app.admin.password')),
        //     ],
        // ];
        // foreach ($users as $key => $userRaw) {
        //     $user = User::create([
        //         'name' => $userRaw['name'],
        //         'email' => $userRaw['email'],
        //         'email_verified_at' => new DateTime(),
        //         'password' => $userRaw['password'],
        //         'about' => 'Super admin of plateform',
        //         'role' => UserRole::admin,
        //         'gender' => GenderEnum::unknown(),
        //         'use_gravatar' => false,
        //         'display_reviews' => true,
        //         'display_favorites' => true,
        //         'display_gender' => true,
        //     ]);
        //     // $userRole = Role::where('name', UserRole::user)->first();
        //     // $adminRole = Role::where('name', UserRole::admin)->first();

        //     // $user->roles()->attach($userRole);
        //     // $user->roles()->attach($adminRole);

        //     MediaService::make($user, $user->slug, 'users', 'avatar')
        //         ->setMedia(DatabaseSeeder::generateAvatar())
        //         ->setColor()
        //     ;
        //     MediaService::make($user, "{$user->slug}-banner", 'users', 'banner')
        //         ->setMedia(DatabaseSeeder::generateBanner())
        //         ->setColor()
        //     ;

        //     $user->save();
        // }
    }
}
