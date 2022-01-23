<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Identifier extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'isbn',
        'isbn13',
        'doi',
        'amazon',
        'google',
    ];

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
