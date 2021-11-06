<?php

namespace App\Query;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class QueryBuilderAddon
{
    public static function for($subject, ?array $with = [], ?Request $request = null)
    {
        $query_method = 'query';
        if (request()->get('random')) {
            $query_method = 'inRandomOrder';
        }

        $subject = $subject::$query_method();
        if (! empty($with)) {
            $subject = $subject->with(...$with);
        }

        return new QueryBuilder($subject, $request);
    }
}
