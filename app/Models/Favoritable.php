<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Favoritable.
 *
 * @property int                             $user_id
 * @property int                             $favoritable_id
 * @property string                          $favoritable_type
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \Eloquent|Model                 $favoritable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereFavoritableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favoritable whereUserId($value)
 * @mixin \Eloquent
 */
class Favoritable extends Model
{
    protected $with = [
        'favoritable',
    ];

    public function favoritable()
    {
        return $this->morphTo();
    }
}
