<?php

namespace App\Models;

use App\Enums\PostCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kiwilan\Steward\Traits\HasBuilder;
use Kiwilan\Steward\Traits\HasSearchableName;
use Kiwilan\Steward\Traits\HasSeo;
use Kiwilan\Steward\Traits\HasShowRoute;
use Kiwilan\Steward\Traits\HasSlug;
use Kiwilan\Steward\Traits\Mediable;
use Kiwilan\Steward\Traits\Publishable;
use Kiwilan\Steward\Traits\Queryable;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use HasSlug;
    use HasShowRoute;
    use Publishable;
    use HasSeo;
    use Searchable;
    use Queryable;
    use Mediable;
    use HasSearchableName;
    use HasBuilder;

    protected $slug_with = 'title';

    protected $meta_title_from = 'title';

    protected $meta_description_from = 'summary';

    protected $query_default_sort = 'published_at';

    protected $query_default_sort_direction = 'desc';

    protected $query_allowed_filters = ['title', 'slug'];

    protected $query_allowed_sorts = ['slug'];

    protected $fillable = [
        'title',
        'summary',
        'is_pinned',
        'category',
        'picture',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'category' => PostCategoryEnum::class,
    ];

    protected $with = [
        'author',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scout.
     */
    public function searchableAs()
    {
        return $this->searchableNameAs();
    }
}
