<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cover extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
    ];

    public function getOriginalAttribute()
    {
        return config('app.url').'/storage/covers-original/'.$this->name.'.webp';
    }

    public function getThumbnailAttribute()
    {
        return config('app.url').'/storage/cache/'.$this->name.'.webp';
    }

    public function getBasicAttribute()
    {
        return config('app.url').'/storage/covers-basic/'.$this->name.'.webp';
    }

    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
