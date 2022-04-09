<?php

namespace App\Http\Queries;

use App\Http\Queries\Addon\QueryOption;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseQuery
{
    public QueryOption $option;
    protected Builder|QueryBuilder $query;
    protected $export;
    protected string $resource;
    protected int $size = 15;

    public function paginate(): LengthAwarePaginator
    {
        return $this->query->paginate(min(100, request()->get('size', $this->option->size ?? $this->size)));
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

    public function getCollection()
    {

        /** @var JsonResource $resource */
        $resource = $this->option->resource;
        $response = $this->option->full ? $this->query->get() : $this->paginate();

        return $resource::collection($response);
    }
}
