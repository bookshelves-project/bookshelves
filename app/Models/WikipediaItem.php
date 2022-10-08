<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kiwilan\Steward\Traits\HasMetaClass;

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

    /**
     * Relationships.
     */
    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    public function serie(): HasOne
    {
        return $this->hasOne(Serie::class);
    }
}
