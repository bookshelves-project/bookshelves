<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WikipediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'language',
        'search_query',
        'query_url',
        'page_id',
        'page_id_url',
        'page_url',
        'extract',
        'picture_url',
    ];

    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    public function serie(): HasOne
    {
        return $this->hasOne(Serie::class);
    }
}
