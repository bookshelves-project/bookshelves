<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Support\Str;
use App\Models\Traits\HasAvatar;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use InteractsWithMedia;
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
        'gravatar',
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
        'gravatar'          => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    // protected $appends = [
    //     'avatar',
    // ];

    public static function boot()
    {
        static::saving(function (User $user) {
            if (! empty($user->slug)) {
                return;
            }
            $user->slug = Str::slug($user->name, '-');
        });

        parent::boot();
    }

    public function getAvatarAttribute(): string
    {
        if ($this->gravatar) {
            $hash = md5(strtolower(trim($this->email)));

            return "http://www.gravatar.com/avatar/$hash";
        }
        if ($this->getMedia('users')->first()) {
            return $this->getMedia('users')->first()?->getUrl();
        }

        return 'https://eu.ui-avatars.com/api/?name='.$this->name.'&color=7F9CF5&background=EBF4FF';
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
