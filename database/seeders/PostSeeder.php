<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        $tags = Tag::factory(30)->create();

        PostCategory::factory(10)
            ->has(Post::factory(30))
            ->create()
        ;

        Post::all()->each(function (Post $post) use ($users, $tags) {
            $post->user()->associate($users->random())->save();
            $post->tags()->attach($tags->random(2));
        });

        Post::query()->each(
            fn (Post $post) => $post
                ->addMedia(database_path('media/placeholder.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('featured-image')
        );
    }
}
