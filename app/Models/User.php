<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Models\Traits\HasAvatar;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasAvatar;
    use HasRoles;

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
        'banner',
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

    public function sendPasswordResetNotification($token)
    {
        $url = config('app.front_url').'/auth/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
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

    // public function hasRole(RoleEnum $role_to_verify): bool
    // {
    //     $roles = [];
    //     foreach ($this->roles as $key => $role) {
    //         array_push($roles, $role->name->value);
    //     }

    //     if (in_array($role_to_verify->value, $roles)) {
    //         return true;
    //     }

    //     return false;
    // }

    public function favorites()
    {
        return Favoritable::where('user_id', $this->id)->orderBy('created_at')->get();
    }

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'favoritable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
