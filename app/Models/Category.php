<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function categorable()
    {
        return $this->morphTo();
    }
}
