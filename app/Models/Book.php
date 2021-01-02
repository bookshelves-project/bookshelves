<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'creator',
        'description',
        'language',
        'date',
        'contributor',
        'identifier',
        'subject',
        'publisher',
        'cover',
        'path',
    ];
}
