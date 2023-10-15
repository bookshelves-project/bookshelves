<?php

namespace App\Models;

use App\Traits\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kiwilan\Steward\Enums\GenderEnum;
use Kiwilan\Steward\Enums\UserRoleEnum;
use Kiwilan\Steward\Traits\HasUsername;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasApiTokens;
    use HasApiTokens, HasFactory, Notifiable;
    use HasAvatar;
    use HasFactory;
    use HasProfilePhoto;
    use HasUsername;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
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
        'profile_photo_url',
    ];

    public function canAccessPanel(Panel $panel): bool
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
            ->orWhere('role', '=', UserRoleEnum::super_admin);
    }

    protected function getIsEditorAttribute(): bool
    {
        return $this->role === UserRoleEnum::editor;
    }

    protected function getIsAdminAttribute(): bool
    {
        return $this->role === UserRoleEnum::admin;
    }

    protected function getIsSuperAdminAttribute(): bool
    {
        return $this->role === UserRoleEnum::super_admin;
    }
}
