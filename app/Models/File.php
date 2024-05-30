<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'path',
        'extension',
        'mime_type',
        'size',
        'is_audiobook',
    ];

    protected $casts = [
        'size' => 'integer',
        'is_audiobook' => 'boolean',
    ];

    public function book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Book::class);
    }

    public function audiobooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Book::class);
    }
}
