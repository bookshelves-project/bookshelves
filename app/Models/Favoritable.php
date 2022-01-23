<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Eloquent|\Illuminate\Database\Eloquent\Model $favoritable
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
