<?php

namespace App\Models;

use App\Enums\BookFormatEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiwilan\Steward\Utils\FileSize;

class File extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'path',
        'basename',
        'extension',
        'format',
        'mime_type',
        'size',
        'is_audiobook',
        'library_id',
    ];

    protected $casts = [
        'size' => 'integer',
        'is_audiobook' => 'boolean',
        'format' => BookFormatEnum::class,
    ];

    protected $appends = [
        'size_human',
    ];

    public function getSizeHumanAttribute(): ?string
    {
        return FileSize::humanReadable($this->size);
    }

    public function book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Book::class);
    }

    public function audiobooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Audiobook::class);
    }

    public function library(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
