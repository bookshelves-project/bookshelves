<?php

use App\Models\Media;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('media return good url', function () {
    Storage::fake('media');

    /** @var Post */
    $post = Post::factory()->create();

    $media = $post->addMedia(database_path('media/placeholder.jpg'))
        ->preservingOriginal()
        ->toMediaCollection('featured-image')
    ;

    expect($media->getUrl())->toBe("/storage/{$media->id}/placeholder.jpg");
});

test('invalid glide image signature return 403', function () {
    Config::set('glide.key', '123456');

    $response = get('/glide/storage/1/placeholder.jpg?w=10&h=10&method=fit');

    $response->assertStatus(403);
});

test('invalid glide image path return 404', function () {
    $response = get('/glide/storage/1/placeholder.jpg?w=10&h=10&method=fit');

    $response->assertStatus(404);
});

test('existing glide image return image', function () {
    Storage::fake('public');

    /** @var Post */
    $post = Post::factory()->create();

    /** @var Media */
    $media = $post->addMedia(database_path('media/placeholder.jpg'))
        ->preservingOriginal()
        ->toMediaCollection('featured-image', 'public')
    ;

    $response = get(
        $media->glide(['w' => 10, 'h' => 10, 'method' => 'fit'])->getUrl()
    );

    $response->assertStatus(200);
});
