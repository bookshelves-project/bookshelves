<?php

namespace Database\Seeders;

use App\Enums\MediaDiskEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // DatabaseSeeder::deleteRoles();

        User::where('role', '!=', 'super_admin')
            ->where('role', '!=', 'admin')
            ->delete()
        ;

        Storage::disk('public')->deleteDirectory('media/users');
        $faker = \Faker\Factory::create();

        // $users = User::whereRelation('roles', 'name', '!==', RoleEnum::admin)->pluck('id')->toArray();
        // User::destroy($users);
        $media = Media::where('collection_name', 'avatar')->pluck('id')->toArray();
        Media::destroy($media);

        // if (! Role::exists()) {
        //     Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        // }

        $users = User::factory()->count(20)->create();

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($users));
        $progress->start();

        $users->each(function ($user) use ($progress, $faker) {
            // $user->roles()->attach(Role::whereName(RoleEnum::user())->first());

            if ($faker->boolean(75)) {
                MediaService::create($user, $user->slug, MediaDiskEnum::user, 'avatar')
                    ->setMedia(DatabaseSeeder::generateAvatar())
                    ->setColor()
                ;
            }
            if ($faker->boolean()) {
                MediaService::create($user, "{$user->slug}-banner", MediaDiskEnum::user, 'banner')
                    ->setMedia(DatabaseSeeder::generateBanner())
                    ->setColor()
                ;
            }

            $user->save();
            $progress->advance();
        });
        $progress->finish();
    }
}
