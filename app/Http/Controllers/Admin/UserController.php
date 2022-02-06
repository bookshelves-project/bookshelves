<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserQuery;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Responses\LoginResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;

#[Prefix('users')]
class UserController extends Controller
{
    #[Get('/', name: 'users')]
    public function index()
    {
        return app(UserQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('users/Index', ['action' => 'list'] + $data))
        ;
    }

    #[Get('create', name: 'users.create')]
    public function create()
    {
        return Inertia::render('users/Index', [
            'action' => 'create',
        ] + app(UserQuery::class)->make()->get());
    }

    #[Get('{user}', name: 'users.show')]
    public function show(User $user)
    {
        return Inertia::render('users/Index', [
            'action' => 'show',
            'user' => UserResource::make($user),
        ] + app(UserQuery::class)->make()->get());
    }

    #[Get('{user}/edit', name: 'users.edit')]
    public function edit(User $user)
    {
        return Inertia::render('users/Index', [
            'action' => 'edit',
            'user' => UserResource::make($user),
        ] + app(UserQuery::class)->make()->get());
    }

    #[Post('/', name: 'users.store')]
    public function store(UserStoreRequest $request)
    {
        User::create($request->all());

        return redirect()->route('admin.users')->with('flash.success', __('User created.'));
    }

    #[Put('{user}', name: 'users.update', middleware: 'can:modify-user,user')]
    public function update(User $user, UserUpdateRequest $request)
    {
        $user->update($request->all());

        return redirect()->route('admin.users')->with('flash.success', __('User updated.'));
    }

    #[Patch('{user}/toggle', name: 'users.toggle', middleware: 'can:modify-user,user')]
    public function toggle(User $user, Request $request)
    {
        $request->validate([
            'active' => 'sometimes|boolean',
        ]);

        $user->update($request->only('active'));

        return redirect()->route('admin.users')->with('flash.success', __('User updated.'));
    }

    #[Delete('{user}', name: 'users.destroy', middleware: 'can:modify-user,user')]
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('flash.success', __('User deleted.'));
    }

    #[Delete('/', name: 'users.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = User::query()->findMany($request->input('ids'))
            ->filter(fn (User $user) => Auth::user()->can('modify-user', $user))
            ->each(fn (User $user) => $user->delete())
            ->count()
        ;

        return redirect()->route('admin.users')->with('flash.success', __(':count users deleted.', ['count' => $count]));
    }

    #[Post('{user}/impersonate', name: 'users.impersonate')]
    public function impersonate(User $user)
    {
        abort_unless(Auth::user()->canImpersonate($user), 403);

        Auth::user()->setImpersonating($user->id);

        session()->flash(
            'flash.warning',
            __('You are connected as :name, you can comeback to you own account from profile menu', [
                'name' => $user->name,
            ])
        );

        return app(LoginResponse::class)->setUser($user);
    }

    #[Post('stop-impersonate', name: 'users.stop-impersonate')]
    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        return redirect()->route('admin.dashboard')->with('flash.success', __('Welcome Back!'));
    }
}
