<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

class QueryExporter
{
    /**
     * @var Builder|QueryBuilder
     */
    private $query;

    /**
     * @var string
     */
    private $resource;

    /**
     * QueryExporter constructor.
     *
     * @param Builder|QueryBuilder $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function resource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    public function get()
    {
        if ($perPage = request()->get('perPage')) {
            return $this->resource::collection(
                $this->query
                    ->paginate($perPage)
                    ->appends(request()->query())
            );
        }

        return $this->resource::collection(
            $this->query->get()
        );
    }

    // public function export(string $export, string $fileName)
    // {
    //     if ($this->resource && ! request()->boolean('export')) {
    //         return $this->get();
    //     }

    //     $date = date('Ymd-His');

    //     return Excel::download(
    //         new $export($this->query->getEloquentBuilder()),
    //         "export-{$fileName}-{$date}.xlsx"
    //     );
    // }
}
