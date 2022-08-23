<?php

namespace App\Models;

use App\Traits\HasShowRoute;
use App\Traits\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Content extends Model
{
    use HasFactory;
    use Mediable;
    use HasShowRoute;

    protected $fillable = [
        'key',
        'title',
        'description',
        'image',
        'hint',
    ];

    protected $show_route_column = 'key';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->key)) {
                $model->key = $model->title ? Str::slug($model->title) : Str::random(10);
            }
        });
    }
}
