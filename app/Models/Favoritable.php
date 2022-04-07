<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Models\Author|\App\Models\Book|\App\Models\Serie $favoritable
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
