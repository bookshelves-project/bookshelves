<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\Traits\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;

/**
 * App\Models\User.
 *
 * @property int                                                                                                                           $id
 * @property string                                                                                                                        $name
 * @property string                                                                                                                        $slug
 * @property string                                                                                                                        $email
 * @property null|\Illuminate\Support\Carbon                                                                                               $email_verified_at
 * @property string                                                                                                                        $password
 * @property null|string                                                                                                                   $two_factor_secret
 * @property null|string                                                                                                                   $two_factor_recovery_codes
 * @property null|string                                                                                                                   $remember_token
 * @property null|int                                                                                                                      $current_team_id
 * @property null|string                                                                                                                   $about
 * @property GenderEnum                                                                                                                    $gender
 * @property null|string                                                                                                                   $pronouns
 * @property bool                                                                                                                          $use_gravatar
 * @property bool                                                                                                                          $display_favorites
 * @property bool                                                                                                                          $display_comments
 * @property bool                                                                                                                          $display_gender
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection                                                                   $books
 * @property null|int                                                                                                                      $books_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection                                                                $comments
 * @property null|int                                                                                                                      $comments_count
 * @property string                                                                                                                        $avatar
 * @property null|string                                                                                                                   $avatar_thumbnail
 * @property null|string                                                                                                                   $color
 * @property string                                                                                                                        $show_link
 * @property string                                                                                                                        $show_link_comments
 * @property string                                                                                                                        $show_link_favorites
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection                     $notifications
 * @property null|int                                                                                                                      $notifications_count
 * @property \App\Models\Role[]|\Illuminate\Database\Eloquent\Collection                                                                   $roles
 * @property null|int                                                                                                                      $roles_count
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[]                                               $tokens
 * @property null|int                                                                                                                      $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayFavorites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePronouns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUseGravatar($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'use_gravatar',
        'display_favorites',
        'display_comments',
        'display_gender',
        'about',
        'gender',
        'pronouns',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'use_gravatar' => 'boolean',
        'display_favorites' => 'boolean',
        'display_comments' => 'boolean',
        'display_gender' => 'boolean',
        'gender' => GenderEnum::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
    ];

    public static function boot()
    {
        static::saving(function (User $user) {
            if (! empty($user->slug)) {
                return;
            }
            $user->slug = Str::slug($user->name, '-').'-'.bin2hex(openssl_random_pseudo_bytes(5));
        });

        parent::boot();
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.users.show', [
            'slug' => $this->slug,
        ]);
    }

    public function getShowLinkCommentsAttribute(): string
    {
        return route('api.users.comments', [
            'slug' => $this->slug,
        ]);
    }

    public function getShowLinkFavoritesAttribute(): string
    {
        return route('api.users.favorites', [
            'slug' => $this->slug,
        ]);
    }

    public function hasRole(RoleEnum $role_to_verify): bool
    {
        $roles = [];
        foreach ($this->roles as $key => $role) {
            array_push($roles, $role->name->value);
        }

        if (in_array($role_to_verify->value, $roles)) {
            return true;
        }

        return false;
    }

    public function favorites()
    {
        return Favoritable::where('user_id', $this->id)->orderBy('created_at')->get();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'favoritable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
