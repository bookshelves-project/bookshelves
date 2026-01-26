<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kiwilan\Steward\Enums\UserRoleEnum;
use Kiwilan\Steward\Traits\HasRole;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRole;
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
        'download_token',
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getCurrentUser(): User|false
    {
        if (! Auth::check()) {
            $firstAdmin = User::where('role', UserRoleEnum::super_admin)->first();
            if (! $firstAdmin) {
                return User::factory()->create([
                    'name' => 'Admin',
                    'email' => config('kiwiflix.super_admin.email'),
                    'password' => Hash::make(config('kiwiflix.super_admin.password')),
                    'role' => UserRoleEnum::super_admin,
                ]);
            }

            return $firstAdmin;
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    /**
     * Generate token for download authentication.
     */
    public function generateDownloadToken(): self
    {
        $token = bin2hex(random_bytes(8));
        $this->download_token = "{$token}-{$this->id}";
        $this->saveQuietly();

        return $this;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isSuperAdmin() && ! $this->is_blocked;
    }
}
