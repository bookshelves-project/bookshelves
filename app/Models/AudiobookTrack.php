<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudiobookTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'track_title',
        'subtitle',
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
        'chapters',
        'added_at',
    ];

    protected $casts = [
        'authors' => 'array',
        'narrators' => 'array',
        'tags' => 'array',
        'volume' => 'float',
        'is_compilation' => 'boolean',
        'duration' => 'float',
        'publish_date' => 'date',
        'chapters' => 'array',
        'added_at' => 'datetime',
    ];

    protected $with = [
        'file',
    ];

    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function file(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
