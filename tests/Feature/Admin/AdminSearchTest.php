<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->superAdmin()->create());
});

test('admin can search posts', function (string $query) {
    Post::factory()->createMany([
        [
            'title' => 'The first post',
        ],
        [
            'title' => 'The second post',
        ],
    ]);

    $response = get("/admin/search/{$query}");

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Search')
            ->where('posts.data.0.title', $query)
    );
})->with([
    ['The first post'],
]);
