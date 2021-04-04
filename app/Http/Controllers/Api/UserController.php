<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Enums\RoleEnum;
use Spatie\Image\Image;
use Illuminate\Http\Request;
use Spatie\Image\Manipulations;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function auth()
    {
        return response()->json('auth');
    }

    public function sanctum(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        return [
            'data'          => $user,
            // 'permissions'   => $user->permissions,
            // 'roles'         => $user->roles,
            'isAdmin'       => $user->hasRole(RoleEnum::ADMIN()),
        ];
    }

    public function users(Request $request)
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($request->photo) {
            $user->clearMediaCollection('users');
            $request->validate([
                'photo' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            /** @var UploadedFile $photo */
            $photo = $request->photo;
            $extension = $photo->extension();
            $photo_path = file_get_contents($photo->path());

            $user->addMediaFromString($photo_path)
                ->setName($user->slug)
                ->setFileName($user->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection('users', 'users');
            $user = $user->refresh();

            $name = pathinfo($user->getMedia('users')->first()?->getPath());
            $formatBasic = config('image.thumbnails.avatar');
            $photo = Image::load($user->getMedia('users')->first()?->getPath())
                ->crop(Manipulations::CROP_CENTER, $formatBasic['width'], $formatBasic['height'])
                ->save();

            return $user;
        }

        return $user;
    }
}
