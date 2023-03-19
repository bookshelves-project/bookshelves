<?php

namespace App\Http\Controllers\Api;

use App\Enums\MediaDiskEnum;
use App\Http\Requests\ProfileDelete;
use App\Http\Requests\ProfileUpdate;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Kiwilan\Steward\Services\MediaService;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

/**
 * @group User: Account
 */
class ProfileController extends Controller
{
    /**
     * GET Current user.
     *
     * @authenticated
     */
    public function sanctum()
    {
        /** @var User $user */
        $user = Auth::user();

        return UserResource::make($user);
    }

    /**
     * POST Update current user.
     *
     * @authenticated
     */
    public function update(ProfileUpdate $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $request->validated();

        $user->slugAttributeIsUpdated('name', $request->name, true);
        $user->update($validated);

        $this->saveMedia(
            $request,
            $user,
            'avatar',
            MediaService::make($user, $user->slug, MediaDiskEnum::user, 'avatar'),
            config('image.user.avatar')
        );
        $this->saveMedia(
            $request,
            $user,
            'banner',
            MediaService::make($user, "{$user->slug}-banner", MediaDiskEnum::user, 'banner'),
            config('image.user.banner')
        );

        $user = $user->refresh();

        return UserResource::make($user);
    }

    /**
     * GET Delete avatar for current user.
     *
     * @authenticated
     */
    public function deleteAvatar()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->clearMediaCollection('avatar');

        return UserResource::make($user);
    }

    /**
     * POST Delete current user.
     *
     * @authenticated
     */
    public function delete(ProfileDelete $request)
    {
        $validated = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $user->delete();

        return response();
    }

    private function saveMedia(Request $request, Model $model, string $field, MediaService $service, mixed $format): void
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
}
