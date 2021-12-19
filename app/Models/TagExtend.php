<?php

namespace App\Models;

use App\Models\Traits\HasFirstChar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\Tag;

/**
 * App\Models\TagExtend.
 *
 * @property int                                                         $id
 * @property array                                                       $name
 * @property array                                                       $slug
 * @property null|string                                                 $type
 * @property null|int                                                    $order_column
 * @property null|\Illuminate\Support\Carbon                             $created_at
 * @property null|\Illuminate\Support\Carbon                             $updated_at
 * @property \App\Models\Book[]|\Illuminate\Database\Eloquent\Collection $books
 * @property null|int                                                    $books_count
 * @property mixed                                                       $first_char
 * @property array                                                       $translations
 *
 * @method static Builder|Tag containing(string $name, $locale = null)
 * @method static Builder|TagExtend newModelQuery()
 * @method static Builder|TagExtend newQuery()
 * @method static Builder|Tag ordered(string $direction = 'asc')
 * @method static Builder|TagExtend query()
 * @method static Builder|TagExtend whereCreatedAt($value)
 * @method static Builder|TagExtend whereId($value)
 * @method static Builder|TagExtend whereIsNegligible(string $negligible)
 * @method static Builder|TagExtend whereName($value)
 * @method static Builder|TagExtend whereOrderColumn($value)
 * @method static Builder|TagExtend whereSlug($value)
 * @method static Builder|TagExtend whereType($value)
 * @method static Builder|TagExtend whereTypeIs(string $type)
 * @method static Builder|TagExtend whereUpdatedAt($value)
 * @method static Builder|Tag withType(?string $type = null)
 * @mixin \Eloquent
 */
class TagExtend extends Tag
{
    use HasFirstChar;

    protected $table = 'tags';

    protected $appends = [
        'first_char',
    ];

    public function scopeWhereTypeIs(Builder $query, string $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeWhereShowNegligible(Builder $query, string $show_negligible)
    {
        $show_negligible = filter_var($show_negligible, FILTER_VALIDATE_BOOLEAN);

        return $show_negligible ? $query : $query->whereHas('books', count: 3);
    }

    public function books(): MorphToMany
    {
        return $this->morphToMany(
            related: Book::class,
            name: 'taggable',
            table: 'taggables',
            foreignPivotKey: 'tag_id',
            relatedPivotKey: 'taggable_id',
            parentKey: 'id',
            relatedKey: 'id',
            inverse: true
        );
    }
}
