<?php

namespace App\Http\Controllers\Api;

use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Database\Eloquent\Model;
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

        $request->validate([
            'name' => 'required|string|max:256',
            'email' => 'required|email|max:256',
            'about' => 'nullable|string|max:2048',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
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

        $this->saveMedia($request, $user, 'avatar', MediaService::create($user, $user->slug, 'users', 'avatar'), config('image.user.avatar'));
        $this->saveMedia($request, $user, 'banner', MediaService::create($user, "{$user->slug}-banner", 'users', 'banner'), config('image.user.banner'));

        $user = $user->refresh();

        return UserResource::make($user);
    }

    public function saveMedia(Request $request, Model $model, string $field, MediaService $service, mixed $format): void
    {
        if ($request->exists($field)) {
            // @phpstan-ignore-next-line
            $model->clearMediaCollection($field);

            $media = $request->file($field);
            $media = base64_encode(File::get($media));

            $service->setMedia($media)
                ->setColor()
            ;

            $model->save();

            // @phpstan-ignore-next-line
            Image::load($model->getMedia($field)->first()?->getPath())
                ->crop(Manipulations::CROP_CENTER, $format['width'], $format['height'])
                ->save()
            ;
        }
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
    }
}
