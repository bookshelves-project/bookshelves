<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Models\Traits\HasImpersonate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\User.
 *
 * @property int                                                         $id
 * @property string                                                      $name
 * @property string                                                      $email
 * @property null|Carbon                                                 $email_verified_at
 * @property string                                                      $password
 * @property null|string                                                 $two_factor_secret
 * @property null|string                                                 $two_factor_recovery_codes
 * @property bool                                                        $active
 * @property null|RoleEnum                                               $role
 * @property null|Carbon                                                 $last_login_at
 * @property null|string                                                 $remember_token
 * @property null|Carbon                                                 $created_at
 * @property null|Carbon                                                 $updated_at
 * @property DatabaseNotification[]|DatabaseNotificationCollection       $notifications
 * @property null|int                                                    $notifications_count
 * @property \App\Models\Post[]|\Illuminate\Database\Eloquent\Collection $posts
 * @property null|int                                                    $posts_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastLoginAt($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasImpersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'role' => RoleEnum::class,
        'last_login_at' => 'datetime',
    ];

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
}
