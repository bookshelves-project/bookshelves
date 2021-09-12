<?php

namespace Database\Seeders;

use Http;
use App\Models\Role;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use App\Providers\ImageProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

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
            $user->addMediaFromBase64($avatar)
                ->setName($user->slug)
                ->setFileName($user->slug . '.' . 'jpg')
                ->toMediaCollection('avatar', 'users');

            $image = $user->getFirstMediaPath('avatar');
            $color = ImageProvider::simple_color_thief($image);
            $media = $user->getFirstMedia('avatar');
            $media->setCustomProperty('color', $color);

            $user->save();
            $progress->advance();
        });
        $progress->finish();
    }
    
    public static function generateAvatar()
    {
        $url = 'https://source.unsplash.com/featured/200x200?face';
        $response = Http::get($url);

        $body = $response->body();
        $base64 = base64_encode($body);
        $original_mime = $response->getHeader('Content-Type')[0];
        $avatar = ('data:' . $original_mime . ';base64,' . $base64);

        return $avatar;
    }
}
