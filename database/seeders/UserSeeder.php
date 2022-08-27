<?php

namespace Database\Seeders;

use App\Enums\MediaDiskEnum;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
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

        User::where('role', '!=', UserRole::super_admin->value)
            ->where('role', '!=', UserRole::admin->value)
            ->delete()
        ;

        Storage::disk('public')->deleteDirectory('media/users');
        $faker = \Faker\Factory::create();

        // $users = User::whereRelation('roles', 'name', '!==', UserRole::admin)->pluck('id')->toArray();
        // User::destroy($users);
        $media = Media::where('collection_name', 'avatar')->pluck('id')->toArray();
        Media::destroy($media);

        // if (! Role::exists()) {
        //     Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        // }

        /** @var Collection<int, User> */
        $users = User::factory()->count(20)->create();

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, $users->count());
        $progress->start();

        $users->each(function (User $user) use ($progress, $faker) {
            // $user->roles()->attach(Role::whereName(UserRole::user())->first());

            if ($faker->boolean(75)) {
                MediaService::create($user, $user->username, MediaDiskEnum::user, 'avatar')
                    ->setMedia(DatabaseSeeder::generateAvatar())
                    ->setColor()
                ;
            }
            if ($faker->boolean()) {
                MediaService::create($user, "{$user->username}-banner", MediaDiskEnum::user, 'banner')
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
