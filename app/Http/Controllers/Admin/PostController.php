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

class PostController extends Controller
{
    public function index()
    {
        return app(PostQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('posts/Index', $data))
        ;
    }

    public function create()
    {
        return Inertia::render('posts/Create');
    }

    public function edit(Post $post)
    {
        return Inertia::render('posts/Edit', [
            'post' => PostResource::make($post->load('category', 'media', 'tags', 'user')),
        ]);
    }

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

    public function toggle(Post $post, Request $request)
    {
        $request->validate([
            'pin' => 'sometimes|boolean',
            'promote' => 'sometimes|boolean',
        ]);

        $post->update($request->only('pin', 'promote'));

        return redirect()->route('admin.posts')->with('flash.success', __('Post updated.'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts')->with('flash.success', __('Post deleted.'));
    }

    public function bulkDestroy(Request $request)
    {
        $count = Post::query()->findMany($request->input('ids'))
            ->each(fn (Post $post) => $post->delete())
            ->count()
        ;

        return redirect()->route('admin.posts')->with('flash.success', __(':count posts deleted.', ['count' => $count]));
    }
}
