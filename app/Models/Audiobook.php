<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiobook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'slug_sort',
        'author_main',
        'authors',
        'narrators',
        'description',
        'publisher',
        'publish_date',
        'language',
        'tags',
        'serie',
        'volume',
        'format',
        'track_number',
        'comment',
        'creation_date',
        'composer',
        'disc_number',
        'is_compilation',
        'encoding',
        'lyrics',
        'stik',
        'duration',
        'physical_path',
        'basename',
        'extension',
        'mime_type',
    ];

    protected $casts = [
        'authors' => 'array',
        'narrators' => 'array',
        'tags' => 'array',
        'volume' => 'integer',
        'is_compilation' => 'boolean',
        'duration' => 'float',
    ];

    public function book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Book::class);
    }
}
