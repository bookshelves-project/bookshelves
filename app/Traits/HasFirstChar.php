<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasFirstChar
{
    public function getFirstCharAttribute()
    {
        return strtoupper(substr(Str::slug($this->name), 0, 1));
    }
}
