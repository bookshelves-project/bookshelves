<?php

namespace Database\Seeders;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Services\ConverterService;
use App\Services\MarkdownToHtmlService;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Post::query()->delete();
        // $users = User::all();
        // $tags = Tag::all();

        // PostCategory::factory(10)
        //     ->has(Post::factory(30))
        //     ->create()
        // ;

        // Post::all()->each(function (Post $post) use ($users, $tags) {
        //     $post->user()->associate($users->random())->save();
        //     $post->tags()->attach($tags->random(2));
        // });

        // Post::query()->each(
        //     fn (Post $post) => $post
        //         ->addMedia(database_path('media/placeholder.jpg'))
        //         ->preservingOriginal()
        //         ->toMediaCollection('featured-image')
        // );

        foreach (Post::all() as $post) {
            $post->clearMediaCollection('featured-image');
            $post->clearMediaCollection('post-images');
        }
        Post::truncate();

        $list = [
            [
                'title' => 'Manage comics or mangas',
                'summary' => 'How to manage comics/mangas with CBZ format on Calibre',
                'category' => 'Calibre',
                'status' => PostStatusEnum::published,
                'published_at' => '03-02-2021',
                'pin' => false,
                'name' => 'calibre-comics',
                'image' => 'calibre',
            ],
            [
                'title' => 'Set metadata',
                'summary' => 'How to update EPUB metadata with Calibre',
                'category' => 'Calibre',
                'status' => PostStatusEnum::published,
                'published_at' => '03-02-2021',
                'pin' => true,
                'name' => 'calibre-metadata',
                'image' => 'calibre',
            ],
            [
                'title' => 'Presentation',
                'summary' => "What is Calibre and why it's a very cool software",
                'category' => 'Calibre',
                'status' => PostStatusEnum::draft,
                'published_at' => '',
                'pin' => false,
                'name' => 'calibre-presentation',
                'image' => 'calibre',
            ],
            [
                'title' => 'Remove DRM',
                'summary' => 'Shut down DRM now!',
                'category' => 'Calibre',
                'status' => PostStatusEnum::published,
                'published_at' => '23-04-2021',
                'pin' => false,
                'name' => 'calibre-remove-drm',
                'image' => 'calibre',
            ],
            [
                'title' => 'Download eBook from eReader',
                'summary' => 'How to download an eBook directly from your eReader?',
                'category' => 'eReader',
                'status' => PostStatusEnum::published,
                'published_at' => '12-05-2021',
                'pin' => false,
                'name' => 'ereader-download-ebook-from-ereader',
                'image' => 'ereader',
            ],
            [
                'title' => 'Get series',
                'summary' => 'Series can not work on the fly with your eReader, this guide explain to force your eReader to display it',
                'category' => 'eReader',
                'status' => PostStatusEnum::published,
                'published_at' => '03-02-2021',
                'pin' => false,
                'name' => 'ereader-series',
                'image' => 'ereader',
            ],
            [
                'title' => 'Tips',
                'summary' => 'Do you know really your Kobo?',
                'category' => 'eReader',
                'status' => PostStatusEnum::published,
                'published_at' => '06-04-2021',
                'pin' => false,
                'name' => 'kobo-tips',
                'image' => 'kobo',
            ],
            // [
            //     'title' => 'Generate EPUB',
            //     'summary' => 'Create new EPUB with Pandoc',
            //     'category' => 'Calibre',
            //     'status' => PostStatusEnum::published,
            //     'published_at' => '',
            //     'name' => 'pandoc-generate-epub',
            //     'image' => 'pandoc',
            // ],
        ];
        $list = ConverterService::arrayToObject($list);

        foreach ($list as $md) {
            $this->getHtmlFromMd($md);
        }
    }

    public static function getHtmlFromMd(object $md)
    {
        $service = MarkdownToHtmlService::create($md, 'posts');

        if ($service) {
            $post = Post::create([
                'title' => $md->title,
                'slug' => Str::slug($md->title),
                'status' => $md->status,
                'summary' => $md->summary,
                'body' => $service->html,
                'published_at' => new DateTime($md->published_at),
                'pin' => $md->pin,
                'meta_title' => $md->title,
                'meta_description' => $md->summary,
            ]);

            $category = PostCategory::whereName($md->category)
                ->first()
            ;
            if (null === $category) {
                $category = PostCategory::create([
                    'name' => $md->category,
                ]);
            }
            $post->category()->associate($category);
            $user = User::whereId(1)
                ->first()
            ;
            $post->user()->associate($user);
            $post->save();

            $service->setImages($post, 'featured-image', 'post-images');
        }
    }
}
