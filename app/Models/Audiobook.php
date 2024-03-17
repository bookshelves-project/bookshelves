<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Traits\HasSlug;

class Audiobook extends Model
{
    use HasFactory;
    use HasSlug;

    protected $slugWith = 'title';

    protected $fillable = [
        'title',
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
        'size',
        'added_at',
    ];

    protected $casts = [
        'authors' => 'array',
        'narrators' => 'array',
        'tags' => 'array',
        'volume' => 'integer',
        'is_compilation' => 'boolean',
        'duration' => 'float',
        'publish_date' => 'date',
        'added_at' => 'datetime',
        'size' => 'integer',
    ];

    public function book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Book::class);
    }
}
