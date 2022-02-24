<?php

namespace App\Http\Queries\Sort;

use App\Models\Author;
use Illuminate\Database\Eloquent\Builder;

class AuthorRelationship implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        // $query->orderBy(
        //     Author::select('name')
        //         ->whereColumn('games.id', 'game_id'),
        //     $direction
        // );
    }
}
