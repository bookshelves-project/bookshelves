<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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

    protected $appends = [
        'is_editor',
        'is_super_admin',
        'is_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_blocked' => 'boolean',
        'role' => UserRole::class,
    ];

    public function canAccessFilament(): bool
    {
        return $this->is_editor || $this->is_admin || $this->is_super_admin && ! $this->is_blocked;
    }

    protected function getIsEditorAttribute(): bool
    {
        return $this->role->value === UserRole::editor->value;
    }

    protected function getIsAdminAttribute(): bool
    {
        return $this->role->value === UserRole::admin->value;
    }

    protected function getIsSuperAdminAttribute(): bool
    {
        return $this->role->value === UserRole::super_admin->value;
    }
}
