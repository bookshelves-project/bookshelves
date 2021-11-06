<?php

namespace App\Query;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class QueryBuilderAddon
{
    public static function for($subject, ?array $with = [], ?array $withCount = [], ?Request $request = null)
    {
        $query_method = 'query';
        if (request()->get('random')) {
            $query_method = 'inRandomOrder';
        }

        $subject = $subject::$query_method();
        if (! empty($with)) {
            $subject = $subject->with(...$with);
        }
        if (! empty($withCount)) {
            $subject = $subject->withCount(...$withCount);
        }

        return new QueryBuilder($subject, $request);
    }
}
