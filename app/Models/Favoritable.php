<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favoritable extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    public function favoritable()
    {
        return $this->morphTo();
    }
}
