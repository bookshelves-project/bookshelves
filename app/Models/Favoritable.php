<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
