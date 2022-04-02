<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginationHelper
{
    public static function paginate(iterable $items, int $size = 15, int $page = 1, array $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $size), $items->count(), $size, $page, $options);
    }

    // public static function paginate(Collection $results, $showsize)
    // {
    //     $pageNumber = Paginator::resolveCurrentPage('page');

    //     $totalPageNumber = $results->count();

    //     return self::paginator($results->forPage($pageNumber, $showsize), $totalPageNumber, $showsize, $pageNumber, [
    //         'path' => Paginator::resolveCurrentPath(),
    //         'pageName' => 'page',
    //     ]);
    // }

    // /**
    //  * Create a new length-aware paginator instance.
    //  *
    //  * @param \Illuminate\Support\Collection $items
    //  * @param int                            $total
    //  * @param int                            $size
    //  * @param int                            $currentPage
    //  * @param array                          $options
    //  *
    //  * @return \Illuminate\Pagination\LengthAwarePaginator
    //  */
    // protected static function paginator($items, $total, $size, $currentPage, $options)
    // {
    //     return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
    //         'items',
    //         'total',
    //         'size',
    //         'currentPage',
    //         'options'
    //     ));
    // }
}
