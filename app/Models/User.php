<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kiwilan\Steward\Enums\GenderEnum;
use Kiwilan\Steward\Enums\UserRoleEnum;
use Kiwilan\Steward\Traits\HasUsername;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasUsername;
    use HasAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        'is_blocked',
        'role',
        'use_gravatar',
        'display_favorites',
        'display_reviews',
        'display_gender',
        'about',
        'gender',
        'pronouns',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_blocked' => 'boolean',
        'role' => UserRoleEnum::class,
        'display_favorites' => 'boolean',
        'display_reviews' => 'boolean',
        'display_gender' => 'boolean',
        'gender' => GenderEnum::class,
    ];

    protected $appends = [
        'is_editor',
        'is_super_admin',
        'is_admin',
    ];

    public function canAccessFilament(): bool
    {
        return $this->is_editor || $this->is_admin || $this->is_super_admin && ! $this->is_blocked;
    }

    public function canManageSettings(): bool
    {
        // return $this->can('manage.settings');
        return true;
    }

    public function scopeWhereHasBackEndAccess(Builder $query): Builder
    {
        return $query->where('role', '=', UserRoleEnum::editor)
            ->orWhere('role', '=', UserRoleEnum::admin)
            ->orWhere('role', '=', UserRoleEnum::super_admin)
        ;
    }

    protected function getIsEditorAttribute(): bool
    {
        return UserRoleEnum::editor === $this->role;
    }

    protected function getIsAdminAttribute(): bool
    {
        return UserRoleEnum::admin === $this->role;
    }

    protected function getIsSuperAdminAttribute(): bool
    {
        return UserRoleEnum::super_admin === $this->role;
    }
}
