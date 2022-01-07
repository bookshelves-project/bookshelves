<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
