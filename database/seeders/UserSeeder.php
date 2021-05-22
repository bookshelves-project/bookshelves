<?php

namespace Database\Seeders;

use DB;
use File;
use Hash;
use DateTime;
use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use Spatie\Image\Image;
use Illuminate\Database\Seeder;
use Spatie\Image\Manipulations;

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
            $userCreated = User::create([
                'name'              => $user['name'],
                'email'             => $user['email'],
                'email_verified_at' => new DateTime(),
                'password'          => $user['password'],
            ]);
            $userCreated->roles()->attach(Role::whereName(RoleEnum::USER())->first());

            if ($userCreated->getMedia('users')->isEmpty()) {
                $disk = 'users';
                $custom_avatar_path = database_path("seeders/media/$disk/$userCreated->slug.jpg");

                if (File::exists($custom_avatar_path)) {
                    $file_path = File::get($custom_avatar_path);
                    $userCreated->addMediaFromString($file_path)
                        ->setName($userCreated->slug)
                        ->setFileName($userCreated->slug . '.' . config('bookshelves.cover_extension'))
                        ->toMediaCollection($disk, $disk);

                    $userCreated->refresh();
                    $formatBasic = config('image.thumbnails.avatar');
                    $avatar = $userCreated->getMedia('users')->first()?->getPath();
                    $avatar = Image::load($avatar)->crop(Manipulations::CROP_CENTER, $formatBasic['width'], $formatBasic['height'])
                        ->format(config('bookshelves.cover_extension'))
                        ->optimize()
                        ->save();
                }
            }

            $userCreated->save();
        }

        $admin = User::whereEmail(config('bookshelves.admin.email'))->first();
        $admin->roles()->attach(Role::whereName(RoleEnum::ADMIN())->first());
        $admin->save();
    }
}
