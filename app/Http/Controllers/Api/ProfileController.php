<?php

namespace App\Http\Controllers\Api;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Rules\EnumRule;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ProfileController extends Controller
{
    public function auth()
    {
        return response()->json('auth');
    }

    public function sanctum(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        return UserResource::make($user);
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // $request->use_gravatar = false;
        // $use_gravatar = filter_var($request->input('use_gravatar'), FILTER_VALIDATE_BOOLEAN);
        $request->validate([
            'name' => 'required|string|max:256',
            'email' => 'required|email|max:256',
            'about' => 'nullable|string|max:2048',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'use_gravatar' => 'required|boolean',
            'display_favorites' => 'required|boolean',
            'display_comments' => 'required|boolean',
            'display_gender' => 'required|boolean',
            'gender' => new EnumRule(GenderEnum::class),
        ]);

        if ($user->name !== $request->name) {
            $slug = $user->slug;
            $slug = explode('-', $slug)[0];
            $user->slug = Str::slug($request->name).'-'.$slug;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;
        $user->use_gravatar = $request->use_gravatar;
        $user->display_comments = $request->display_comments;
        $user->display_favorites = $request->display_favorites;
        $user->display_gender = $request->display_gender;
        $user->gender = $request->gender;
        $user->save();

        if ($request->avatar) {
            $user->clearMediaCollection('avatar');

            $avatar = $request->file('avatar');
            $avatar = File::get($avatar);

            $user->addMediaFromString($avatar)
                ->setName($user->slug)
                ->setFileName($user->slug.'.'.config('bookshelves.cover_extension'))
                ->toMediaCollection('avatar', 'users')
            ;
            $user = $user->refresh();

            $formatBasic = config('image.thumbnails.avatar');
            $avatar = Image::load($user->getMedia('avatar')->first()?->getPath())
                ->crop(Manipulations::CROP_CENTER, $formatBasic['width'], $formatBasic['height'])
                ->save()
            ;

            return [
                'data' => $user,
                'isAdmin' => $user->hasRole(RoleEnum::admin()),
            ];
        }

        return UserResource::make($user);
    }

    public function deleteAvatar()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->clearMediaCollection('avatar');

        return UserResource::make($user);
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string|max:256',
            'password' => 'required|string|max:256',
            'password_confirmation' => 'required|string|max:256',
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
