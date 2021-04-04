<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $casts = [
        'name' => RoleEnum::class,
    ];

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
