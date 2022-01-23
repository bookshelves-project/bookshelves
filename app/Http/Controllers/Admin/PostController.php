<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\PostQuery;
use App\Http\Requests\Admin\PostStoreRequest;
use App\Http\Requests\Admin\PostUpdateRequest;
use App\Http\Resources\Admin\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post as HttpPost;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('posts')]
class PostController extends Controller
{
    #[Get('/', name: 'posts')]
    public function index()
    {
        return app(PostQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('posts/Index', $data))
        ;
    }

    #[Get('create', name: 'posts.create')]
    public function create()
    {
        return Inertia::render('posts/Create');
    }

    #[Get('{post}/edit', name: 'posts.edit')]
    public function edit(Post $post)
    {
        return Inertia::render('posts/Edit', [
            'post' => PostResource::make($post->load('category', 'media', 'tags', 'user')),
        ]);
    }

    #[HttpPost('/', name: 'posts.store')]
    public function store(PostStoreRequest $request)
    {
        $post = Post::create($request->all());

        $post->syncTags($request->tags);

        if ($request->featured_image_file) {
            $post->addMediaFromRequest('featured_image_file')
                ->toMediaCollection('featured-image')
            ;
        }

        return redirect()->route('admin.posts')->with('flash.success', __('Post created.'));
    }

    #[Put('{post}', name: 'posts.update')]
    public function update(Post $post, PostUpdateRequest $request)
    {
        $post->update($request->all());

        $post->syncTags($request->tags);

        if ($request->featured_image_delete) {
            $post->clearMediaCollection('featured-image');
        }

        if ($request->featured_image_file) {
            $post->addMediaFromRequest('featured_image_file')
                ->toMediaCollection('featured-image')
            ;
        }

        return redirect()->route('admin.posts')->with('flash.success', __('Post updated.'));
    }

    #[Patch('{post}/toggle', name: 'posts.toggle')]
    public function toggle(Post $post, Request $request)
    {
        $request->validate([
            'pin' => 'sometimes|boolean',
            'promote' => 'sometimes|boolean',
        ]);

        $post->update($request->only('pin', 'promote'));

        return redirect()->route('admin.posts')->with('flash.success', __('Post updated.'));
    }

    #[Delete('{post}', name: 'posts.destroy')]
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts')->with('flash.success', __('Post deleted.'));
    }

    #[Delete('/', name: 'posts.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Post::query()->findMany($request->input('ids'))
            ->each(fn (Post $post) => $post->delete())
            ->count()
        ;

        return redirect()->route('admin.posts')->with('flash.success', __(':count posts deleted.', ['count' => $count]));
    }
}
