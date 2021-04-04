<?php

namespace App\Http\Controllers\Api;

use Str;
use Auth;
use Hash;
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

        $request->gravatar = false;
        $gravatar = filter_var($request->input('gravatar'), FILTER_VALIDATE_BOOLEAN);
        $request->validate([
            'name'     => 'required|string|max:256',
            'email'    => 'required|email|max:256',
            'photo'    => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->name = $request->name;
        $user->slug = Str::slug($request->name);
        $user->email = $request->email;
        $user->gravatar = $gravatar;
        $user->save();

        if ($request->photo) {
            $user->clearMediaCollection('users');

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

            return [
                'data'          => $user,
                'isAdmin'       => $user->hasRole(RoleEnum::ADMIN()),
            ];
        }

        return [
            'data'          => $user,
            'isAdmin'       => $user->hasRole(RoleEnum::ADMIN()),
        ];
    }

    public function deleteAvatar()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->clearMediaCollection('users');

        return [
            'data'          => $user,
            'isAdmin'       => $user->hasRole(RoleEnum::ADMIN()),
        ];
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password'         => 'required|string|max:256',
            'password'                 => 'required|string|max:256',
            'password_confirmation'    => 'required|string|max:256',
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            if ($request->password === $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                return response()->json([
                    'success' => __('New password and new password confirmation does not match.'),
                ], 402);
            }
        } else {
            return response()->json([
                'success' => __('The provided password does not match your current password.'),
            ], 402);
        }

        // Validator::make($input, [
        //     'current_password' => ['required', 'string'],
        //     'password'         => $this->passwordRules(),
        // ])->after(function ($validator) use ($user, $input) {
        //     if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
        //         $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
        //     }
        // })->validateWithBag('updatePassword');

        // $user->forceFill([
        //     'password' => Hash::make($input['password']),
        // ])->save();
    }
}
