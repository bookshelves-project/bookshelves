<?php

namespace App\Query\Sort;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;

class LanguageRelationship implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        // $query->orderBy(
        //     Language::select('slug')
        //         ->whereColumn('army_types.id', 'army_type_id'),
        //     $direction
        // );
    }
}
