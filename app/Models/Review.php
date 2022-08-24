<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
        'reviewable_id',
        'reviewable_type',
        'user_id',
    ];

    /**
     * Relationships
     */

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'reviewable', 'reviews', 'reviewable_id');
    }

    public function series():MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'reviewable', 'reviews', 'reviewable_id');
    }

    public function authors(): MorphToMany
    {
        return $this->morphedByMany(Author::class, 'reviewable', 'reviews', 'reviewable_id');
    }
}
