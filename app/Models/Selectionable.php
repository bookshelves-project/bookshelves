<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selectionable extends Model
{
    public function selectionable()
    {
        return $this->morphTo();
    }
}
