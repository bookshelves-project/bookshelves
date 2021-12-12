<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Selectionable.
 *
 * @property int                             $user_id
 * @property int                             $selectionable_id
 * @property string                          $selectionable_type
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \Eloquent|Model                 $selectionable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereSelectionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereSelectionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selectionable whereUserId($value)
 * @mixin \Eloquent
 */
class Selectionable extends Model
{
    public function selectionable()
    {
        return $this->morphTo();
    }
}
