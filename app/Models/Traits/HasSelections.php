<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Manage selections with `MorphToMany` `selectionables`
 */
trait HasSelections
{
    public function selections(): MorphToMany
    {
        return $this->morphToMany(User::class, 'selectionable')->withTimestamps();
    }
}
