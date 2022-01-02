<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            FavoriteSeeder::class,
            CommentSeeder::class,
            CmsSeeder::class,
        ]);
    }

    public static function deleteRoles()
    {
        // $role = RoleEnum::admin();
        // $role = Role::where('name', $role)->first();
        // DB::statement('SET foreign_key_checks=0');
        // DB::table('model_has_roles')->truncate();
        // DB::table('model_has_permissions')->truncate();
        // DB::statement('SET foreign_key_checks=1');
    }

    public static function generateAvatar()
    {
        $index = rand(1, 15);
        $path = database_path('seeders/media/users/avatars/user-'.$index.'.webp');

        return base64_encode(File::get($path));
    }

    public static function generateBanner()
    {
        $path = database_path('seeders/media/users/banners/default.jpg');

        return base64_encode(File::get($path));
    }
}
