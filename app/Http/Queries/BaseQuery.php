<?php

namespace App\Http\Queries;

use Closure;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Queries\Addon\QueryOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

abstract class BaseQuery
{
    public QueryOption $option;
    protected Builder|QueryBuilder $query;
    protected $export;
    protected string $resource;
    protected int $perPage = 15;

    public function paginate(): LengthAwarePaginator
    {
        return $this->query->paginate(min(100, request()->get('perPage', $this->option->perPage ?? $this->perPage)));
    }

    abstract public function collection(): AnonymousResourceCollection;

    abstract public function get(): array;

    public function paginateOrExport(?Closure $response = null)
    {
        if (! $response || request()->wantsJson()) {
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
