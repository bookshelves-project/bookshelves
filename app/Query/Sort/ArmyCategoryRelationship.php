<?php

namespace App\Query\Sort;

use App\Models\ArmyCategory;
use Illuminate\Database\Eloquent\Builder;

class ArmyCategoryRelationship implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        // $query->orderBy(
        //     ArmyCategory::select('name')
        //         ->whereColumn('army_categories.id', 'army_category_id'),
        //     $direction
        // );
    }
}
