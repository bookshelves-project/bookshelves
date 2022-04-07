<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Eloquent|\Illuminate\Database\Eloquent\Model $favoritable
 */
class Favoritable extends Model
{
    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];

    protected $with = [
        'favoritable',
    ];

    public function favoritable()
    {
        return $this->morphTo();
    }
}
