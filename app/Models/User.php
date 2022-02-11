<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasImpersonate;
use App\Models\Traits\HasUserSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use Notifiable;
    use HasImpersonate;
    use HasApiTokens;
    use HasAvatar;
    use HasUserSlug;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'role',
        'slug',
        'use_gravatar',
        'display_favorites',
        'display_comments',
        'display_gender',
        'about',
        'gender',
        'pronouns',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'role' => RoleEnum::class,
        'last_login_at' => 'datetime',
    ];

    public static function boot()
    {
        static::creating(function (User $user) {
            $user->slug = self::generateSlug($user, 'name', true);
        });

        parent::boot();
    }

    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
        }
    }

    public function hasAdminAccess()
    {
        return $this->role->equals(RoleEnum::super_admin(), RoleEnum::admin());
    }

    public function canUpdate(User $user)
    {
        if ($this->role->equals(RoleEnum::admin())) {
            return ! $user->role->equals(RoleEnum::super_admin());
        }

        return $this->role->equals(RoleEnum::super_admin());
    }

    public function getShowLinkAttribute(): string
    {
        return route('api.v1.users.show', [
            'slug' => $this->slug,
        ]);
    }

    public function getShowLinkCommentsAttribute(): string
    {
        return route('api.v1.users.comments', [
            'slug' => $this->slug,
        ]);
    }

    public function getShowLinkFavoritesAttribute(): string
    {
        return route('api.v1.users.favorites', [
            'slug' => $this->slug,
        ]);
    }

    public function hasRole(RoleEnum $role): bool
    {
        // $roles = [];
        // foreach ($this->roles as $key => $role) {
        //     array_push($roles, $role->name->value);
        // }

        // if (in_array($role_to_verify->value, $roles)) {
        //     return true;
        // }

        return $this->role == $role->value;
    }

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
