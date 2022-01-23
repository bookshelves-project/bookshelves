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

class UserController extends Controller
{
    public function index()
    {
        return app(UserQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('users/Index', ['action' => 'list'] + $data))
        ;
    }

    public function create()
    {
        return Inertia::render('users/Index', [
            'action' => 'create',
        ] + app(UserQuery::class)->make()->get());
    }

    public function show(User $user)
    {
        return Inertia::render('users/Index', [
            'action' => 'show',
            'user' => UserResource::make($user),
        ] + app(UserQuery::class)->make()->get());
    }

    public function edit(User $user)
    {
        return Inertia::render('users/Index', [
            'action' => 'edit',
            'user' => UserResource::make($user),
        ] + app(UserQuery::class)->make()->get());
    }

    public function store(UserStoreRequest $request)
    {
        User::create($request->all());

        return redirect()->route('admin.users')->with('flash.success', __('User created.'));
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $user->update($request->all());

        return redirect()->route('admin.users')->with('flash.success', __('User updated.'));
    }

    public function toggle(User $user, Request $request)
    {
        $request->validate([
            'active' => 'sometimes|boolean',
        ]);

        $user->update($request->only('active'));

        return redirect()->route('admin.users')->with('flash.success', __('User updated.'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('flash.success', __('User deleted.'));
    }

    public function bulkDestroy(Request $request)
    {
        $count = User::query()->findMany($request->input('ids'))
            ->filter(fn (User $user) => Auth::user()->can('modify-user', $user))
            ->each(fn (User $user) => $user->delete())
            ->count()
        ;

        return redirect()->route('admin.users')->with('flash.success', __(':count users deleted.', ['count' => $count]));
    }

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

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        return redirect()->route('admin.dashboard')->with('flash.success', __('Welcome Back!'));
    }
}
