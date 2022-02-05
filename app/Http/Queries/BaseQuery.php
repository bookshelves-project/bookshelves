<?php

namespace App\Http\Queries;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseQuery
{
    protected Builder|QueryBuilder $query;
    protected $export;
    protected string $resource;
    protected int $perPage = 15;

    public function paginate()
    {
        return $this->query->paginate(min(100, request()->get('perPage', $this->perPage)));
    }

    abstract public function collection(): AnonymousResourceCollection;

    abstract public function get(): array;

    public function paginateOrExport(Closure $response)
    {
        if (request()->wantsJson()) {
            return $this->collection();
        }

        if (request()->get('export')) {
            $fileName = Str::slug(trans_choice("crud.{$this->resource}.name", 10));
            $date = date('Ymd-His');

            return Excel::download($this->export, "export-{$fileName}-{$date}.xlsx");
        }

        return $response($this->get());
    }
}
