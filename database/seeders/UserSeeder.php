<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use App\Providers\ImageProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('media/users');
        
        $users = User::whereRelation('roles', 'name', '!==', RoleEnum::ADMIN())->pluck('id')->toArray();
        User::destroy($users);
        $media = Media::where('collection_name', 'avatar')->pluck('id')->toArray();
        Media::destroy($media);
        
        if (! Role::exists()) {
            Artisan::call('db:seed', ['--class' => 'RoleSeeder', '--force' => true]);
        }
        
        $users = User::factory()->count(20)->create();

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($users));
        $progress->start();

        $users->each(function ($user) use ($progress) {
            $user->roles()->attach(Role::whereName(RoleEnum::USER())->first());

            $avatar = self::generateAvatar();
            $user->addMediaFromString($avatar)
                ->setName($user->slug)
                ->setFileName($user->slug . '.' . 'webp')
                ->toMediaCollection('avatar', 'users');

            $image = $user->getFirstMediaPath('avatar');
            $color = ImageProvider::simple_color_thief($image);
            $media = $user->getFirstMedia('avatar');
            $media->setCustomProperty('color', $color);
            $media->save();

            $user->save();
            $progress->advance();
        });
        $progress->finish();
    }
    
    public static function generateAvatar()
    {
        $index = rand(1, 15);
        $path = database_path('seeders/media/users/user-' . $index . '.webp');
        $file = File::get($path);
        

        return $file;
    }
}
