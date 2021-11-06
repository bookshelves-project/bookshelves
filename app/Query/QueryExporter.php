<?php

namespace App\Query;

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
        $query = $this->query;
        if ($limit = request()->get('limit')) {
            $query = $query
                ->limit($limit)
            ;
        }

        if ($perPage = request()->get('per-page')) {
            return $this->resource::collection(
                $query
                    ->paginate($perPage)
                    ->appends(request()->query())
            );
        }

        return $this->resource::collection(
            $query->get()
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
