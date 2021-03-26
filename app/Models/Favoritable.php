<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoritable extends Model
{
    protected $fillable = [
    ];

    public function favoritable()
    {
        return $this->morphTo();
    }
}
