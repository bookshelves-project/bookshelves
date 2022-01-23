<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasFirstChar
{
    public function getFirstCharAttribute()
    {
        // @phpstan-ignore-next-line
        return strtoupper(substr(Str::slug($this->name), 0, 1));
    }
}
