<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role.
 *
 * @property int      $id
 * @property RoleEnum $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public $timestamps = false;

    protected $casts = [
        'name' => RoleEnum::class,
    ];

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
